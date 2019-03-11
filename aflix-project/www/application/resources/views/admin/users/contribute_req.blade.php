@extends('admin.master')

@section('content')
<?php
@$a=$_GET['email'];
@$b=$_GET['user'];
if(@$a!='')
{
@$auth2= DB::select("update users set contribute_req_status=1,contribute='contribute' where email='$a'");



Mail::send('emails.approvereq',
            array('username' => $_GET['user'], 'email' => $_GET['email']),
            function($message) {
                $message->to($_GET['email'], $_GET['user'])->subject('Welcome To aflix.amlin.com');
            });

			$time=strtotime(date('Y-m-d'));
 $month=date("F",$time);
 $year=date("Y",$time);
			$insert=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','January','$year')");
            $insert1=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','February','$year')");

            $insert2=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','March','$year')");

            $insert3=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','April','$year')");

            $insert4=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','May','$year')");

            $insert5=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','June','$year')");

            $insert6=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','July','$year')");

            $insert7=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','August','$year')");

            $insert8=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','September','$year')");

            $insert9=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','October','$year')");

            $insert10=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','November','$year')");

            $insert11=DB::select("insert into month_wise_subscrition(user_id,month,year)value('$a','December','$year')");


			echo "<script>window.location='contributor_req'</script>";
}

?>

<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#all_users" aria-controls="indivdual" role="tab" data-toggle="tab">Users</a></li>
  <li role="presentation"><a href="#organization" aria-controls="Organization" role="tab" data-toggle="tab">Organization</a></li>
</ul>

<div class="tab-content">

  <div role="tabpanel" class="tab-pane active" id="all_users">

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-user"></i>All Users Contributor Request</h3><!--<a href="{{ URL::to('admin/user/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>-->
			</div>
			<div class="col-md-4">
				<?php $search = request('s'); ?>

        <form method="get" role="form" class="search-form-full"> <div class="form-group">
          <input type="text" class="form-control" name="s" id="search-input" value="@if(!empty($search)){{ $search }}@endif" placeholder="Search...">
             <i class="entypo-search"></i>
           </div>


           <hr />

             <button type="submit" class="btn btn-default" role="button">Search</button>
         </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>


	<table class="table table-striped">
		<tr class="table-header">
			<th>Username</th>
			<th>Email</th>
			<th>User Type</th>
			<th>Upload Videos</th>
			<th>Request</th>

			<?php
			foreach($users as $user)
			{
			?>
			<tr>
				<td><?php echo $user->username;?></td>
				<td><?php echo $user->email;?></td>
				<td>
					@if($user->role == 'subscriber')
						<div class="label label-success"><i class="fa fa-user"></i>
						Subscribed User <?php if($user->contribute!=''){ echo " / Contributor"; }?></div>
					@elseif($user->role == 'registered')
						<div class="label label-info"><i class="fa fa-envelope"></i>
						Registered User / <?php if($user->contribute!=''){ echo " / Contributor"; }?></div>
					@elseif($user->role == 'demo')
						<div class="label label-danger"><i class="fa fa-life-saver"></i>
						Demo User</div>
					@elseif($user->role == 'admin')
						<div class="label label-primary"><i class="fa fa-star"></i>
						<?= ucfirst($user->role) ?> User</div>
					@endif

				</td>


				<td>
				<a href="/admin_view_contribute_video?id=<?php echo $user->id?>">View</a>
				</td>
				<td>
				<?php
				if($user->contribute_req == 1 AND $user->contribute_req_status == 0)
				{
				?>
				<a href="?email=<?php echo $user->email?>&user=<?php echo $user->username?>" class="btn btn-xs btn-danger delete2"><span class="fa fa-user"> Pending Request</a>
				<?php
				}
				else
				{
				?>
				<a href="#" class="label label-success "><span class="fa fa-user"> Approve Request</span></a>
				<?php
				}
				?>
				</td>





			</tr>
			<?php
			}
			?>
	</table>

</div>


<div role="tabpanel" class="tab-pane" id="organization">

  <form method="POST" action="<?= $post_route ?>" id="update_profile_form" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

    <div id="user-badge">
      @if(isset($user->avatar))<?php $avatar = $user->avatar; ?>@else<?php $avatar = 'default.jpg'; ?>@endif
      <img src="<?= Config::get('site.uploads_url') . 'avatars/' . $avatar ?>" />
      <label for="avatar">@if(isset($user->username))<?= ucfirst($user->username). '\'s'; ?>@endif Profile Image</label>
      <input type="file" multiple="true" class="form-control" name="avatar" id="avatar" />
    </div>

    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
      <div class="panel-title">First Name</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
      <div class="panel-body" style="display: block;">
        <?php if($errors->first('username')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('username'); ?></div><?php endif; ?>
        <p>User's First Name</p>
        <input type="text" class="form-control" name="username" id="username" value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
      </div>
    </div>

    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
      <div class="panel-title">Email</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
      <div class="panel-body" style="display: block;">
        <?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
        <p>User's Email Address</p>
        <input type="text" class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
      </div>
    </div>

    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
      <div class="panel-title">Organization Name</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
      <div class="panel-body" style="display: block;">
        <?php if($errors->first('organization_name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('organization_name'); ?></div><?php endif; ?>
        <p>User's Organization Name</p>
        <input type="text" class="form-control" name="organization_name" id="organization_name" value="<?php if(!empty($user->organization_name)): ?><?= $user->organization_name ?><?php endif; ?>" />
      </div>
    </div>


    <div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
      <div class="panel-title">Password</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
      <div class="panel-body" style="display: block;">
        @if(isset($user->password))
          <p>(leave empty to keep your original password)</p>
        @else
          <p>Enter users password:</p>
        @endif
        <input type="password" class="form-control" name="password" id="password" value="" />
      </div>
    </div>


    @if($id = $user->id)
      <input type="hidden" id="id" name="id" value="{{ $id }}" />
    @endif

    <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
    <input type="submit" value="{{ $button_text }}" class="btn btn-success pull-right" />

    <div class="clear"></div>
  </form>

</div>
</div>


	@section('javascript')

	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete1').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to Block this user?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>
	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to Active this user?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>

	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete2').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to Approve this user Request?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>

	@stop

@stop
