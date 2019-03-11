#!/usr/bin/perl
# debian: aptitude -y install libhttp-daemon-perl libjson-perl libyaml-perl

use strict;
no warnings;
use HTTP::Daemon;
use HTTP::Status;
use JSON;
use YAML::Loader;
use Cwd 'abs_path';
use File::Basename;
use threads ('yield',
             'stack_size' => 64*4096,
             'exit' => 'threads_only',
             'stringify');
use Thread::Queue;

my $debug = 0;
my $dryRun = 0;

use constant PIDFILE => '/var/run/git-deploy.pid';

#$debug = 1 if ($^O=~m/darwin/i);
my $deployHome = dirname(abs_path($0));
chdir $deployHome;

$| = 1;
my $qDeployTasks = new Thread::Queue();

unless ($debug)
{
    fork and exit;
    open(my $fhPidFile, ">", PIDFILE);
    print $fhPidFile $$ . "\n"; 
    close $fhPidFile;
    STDOUT->autoflush(1);
    STDERR->autoflush(1);
}

$SIG{INT} = sub
{
    $_->kill('SIGTERM') foreach threads->list(threads::running);
    sleep 0.1 while threads->list(threads::running) > 0;
    $_->join() foreach threads->list(threads::joinable);
    threads->exit();
};

threads->create('threadGitSyncer')->detach();

my $d = HTTP::Daemon->new(
    #LocalAddr => 'localhost',
    LocalPort => 39901,
    Reuse => 1,
    Listen => 20) || die $!;

while (my $c = $d->accept)
{
    debug('Connection accepted');
    onClientRequest($c);
    $c->close;
}

sub onClientRequest
{
    my $c = shift;
    my $responceText = 'Ok';
    
    if( my $req = $c->get_request)
    {
       if ($req->method eq "POST" and $req->content =~ m/(\{.*\})/)
       {
        my $json_source = $1;
        debug('Received HTTP POST');
        my $js = decode_json($json_source);
        
        if (defined $js->{'object_kind'} and $js->{'object_kind'} eq 'push')
        {
            my $hookRepo = $js->{'repository'}->{'name'};
            my $hookBranch = (split('/',$js->{'ref'}))[2];
            $qDeployTasks->enqueue({ 'repo' => $hookRepo,
                                    'branch' => $hookBranch});
            debug('Enqueued the task ' . $hookRepo . ' branch: ' . $hookBranch);
        }
        else
        {
            $responceText = 'Error: unsupported request';
        }
       } else
       {
        $responceText = 'Error';
       }
        my $response = HTTP::Response->new(RC_OK);
        $response->content($responceText);
        $response->header( 'Content-Type' => 'text/plain' );
        $c->send_response( $response );
    }
}

sub threadGitSyncer
{
    $SIG{'TERM'} = sub { threads->exit( ) };
    while (1)
    {
        my $task = $qDeployTasks->dequeue_nb;
        if (defined $task and defined $task->{'repo'} and defined $task->{'branch'})
        {
            debug('Dequeued the task, running onGitPush');
            doDeploy(loadBranchConfig($task->{'repo'}, $task->{'branch'}));
        } else
        {
            sleep 1;
        }
    }
}

sub doDeploy
{
    my $deploy = shift;
    return unless defined $deploy;

    unless (defined $deploy->{'repoHome'} and (-d $deploy->{'repoHome'}))
    {
        debug("doDeploy: repoHome: " . $deploy->{'repoHome'} . ' missing. Ignoring push hook');
        return;
    }

    debug("doDeploy: repoHome: " . $deploy->{'repoHome'});

    chdir $deploy->{'repoHome'};
    system('git reset --hard');
    system('git pull');

    # TODO: check is src available
    unless (defined $deploy->{'syncSrc'} and (-d $deploy->{'syncSrc'}))
    {
        debug('Not valid syncSrc directory: ' . $deploy->{'syncSrc'} . '. Nothing to do after git pull...');
        return;
    }
    
    if (defined $deploy->{'syncDst'})
    {
        mkdir $deploy->{'syncDst'} unless (-d $deploy->{'syncDst'});
        unless (-d $deploy->{'syncDst'})
        {
            debug('Error: Cannot create destination directory ' . $deploy->{'syncDst'});
            return;
        }
        
        $deploy->{'syncDst'}=~s/\/$//g;
        $deploy->{'syncSrc'}=~s/\/$//g;
        
        my $rsyncCmd = 'rsync -aqr --delete';
        
        if (defined $deploy->{'ignoreFile'} and -f $deployHome . '/' . $deploy->{'ignoreFile'})
        {
            $rsyncCmd .= ' --exclude-from=' . $deployHome . '/' . $deploy->{'ignoreFile'};
        }
        
        $rsyncCmd .= ' ' . $deploy->{'syncSrc'} . '/';
        $rsyncCmd .= ' ' . $deploy->{'syncDst'} . '/';
        debug('rsync command: ' . $rsyncCmd);
        system($rsyncCmd) unless ($dryRun);
        
        if (defined $deploy->{'afterPull'})
        {
            foreach my $cmdLine (split /\n/ ,$deploy->{'afterPull'}) {
                chomp $cmdLine;
                debug('Executing afterPull: ' . $cmdLine);
                system($cmdLine) unless ($dryRun);
            }
        } else
        {
            debug('No afterPull commands defined for this repo/branch');
        }
    }
}

sub loadBranchConfig
{
    my $repo = shift;
    my $branch = shift;
    
    my $deployConfig = $deployHome . '/git-deploy.yml';
    debug('Loading YAML config from ' . $deployConfig);

    my $yaml = '';
    open(my $fh, '<', $deployConfig) or warn 'Cant load ' . $deployConfig;
    while (<$fh>) { $yaml .= $_; }
    close $fh;
    
    my $loader = YAML::Loader->new;
    my $hash = $loader->load($yaml);

    if (defined (my $inRepo = $hash->{'repo'}->{$repo}))
    {
        foreach my $inBranch (@$inRepo)
        {
            if ($inBranch->{'branch'} eq $branch) {
                debug('Found YAML config for ' . $repo . ' / ' . $branch);
                return $inBranch;
            }
        }
    }
    debug('YAML config for ' . $repo . ' / ' . $branch . ' not found');
    return undef;
}

sub debug
{
    my $msg = shift;
    chomp $msg;
    print $msg . "\n" if ($debug);
}
