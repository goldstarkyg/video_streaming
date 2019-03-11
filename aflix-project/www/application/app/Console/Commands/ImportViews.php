<?php

namespace HelloVideo\Console\Commands;

use Illuminate\Console\Command;
use HelloVideo\Http\Controllers\UpdateVideoViewController;
use Log;

class ImportViews extends Command
{
    protected $signature = 'aflix:wistia';
    protected $description = 'Import Video Views From Wistia API';
    protected $controller;

    public function __construct(UpdateVideoViewController $controller)
    {
        parent::__construct();

        $this->controller = $controller;
    }

    public function handle()
    {        
        
        $start_time = time();

        $this->controller->updateVideoViewsWistia();
            
        Log::info('- Update Started At' . ' (' . (time() - $start_time) . ' sec)');
            
        $this->comment('- Update End At' . ' (' . (time() - $start_time) . ' sec)');
       
    }
}
