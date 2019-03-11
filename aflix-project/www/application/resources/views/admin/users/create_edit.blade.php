@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ '/hellovideo/application/application/assets/js/tagsinput/jquery.tagsinput.css' }}" />
@stop


@section('content')

<div id="admin-container">
<!-- This is where -->

	<div class="admin-section-title">
	@if(!empty($user->id))
		<h3><i class="entypo-user"></i> {{ $user->username }}</h3>
		<a href="{{ URL::to('user') . '/' . $user->username }}" target="_blank" class="btn btn-info">
			<i class="fa fa-eye"></i> Preview <i class="fa fa-external-link"></i>
		</a>
	@else
		<h3><i class="entypo-user"></i> Add New User</h3>
	@endif
	</div>
	<div class="clear"></div>



		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#indivdual" aria-controls="indivdual" role="tab" data-toggle="tab">indivdual</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="indivdual">
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
							<div class="panel-title">Birth Date</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
							<div class="panel-body" style="display: block;">
								<p>User's Birth Date</p>
								<input type="date" class="form-control" name="dob" id="dob" value="<?php if(!empty($user->dob)): ?><?= $user->dob ?><?php endif; ?>" />
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

						<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
							<div class="panel-title">Gender</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
							<div class="panel-body" style="display: block;">
								<p>User's Gender</p>
								<select class="form-control" name="gender" id="gender">
								<option>Select Gender</option>
								<option value="Male" <?php if(@$user->gender=="Male"){ echo "selected" ;} ?>>Male</option>
								<option value="Female" <?php if(@$user->gender=="Female"){ echo "selected" ;} ?>>Female</option>
								</select>
							</div>
						</div>

						<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
							<div class="panel-title">Profession</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
							<div class="panel-body" style="display: block;">
								<p>User's Profession</p>
								<select class="form-control" id="profession" name="profession" required>
								<option>Select Profession</option>
								<option value="Manager" <?php if(@$user->profession=="Manager"){ echo "selected" ;} ?>>Manager</option>
								<option value="Executive" <?php if(@$user->profession=="Executive"){ echo "selected" ;} ?>>Executive</option>
								<option value="Clerk" <?php if(@$user->profession=="Clerk"){ echo "selected" ;} ?>>Clerk</option>
								<option value="Business Owner" <?php if(@$user->profession=="Business Owner"){ echo "selected" ;} ?>>Business Owner</option>
								<option value="Government" <?php if(@$user->profession=="Government"){ echo "selected" ;} ?>>Government</option>

								</select>
							</div>
						</div>

						<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
							<div class="panel-title">Income</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
							<div class="panel-body" style="display: block;">
								<p>User's Income</p>
								<select class="form-control" id="income" name="income" required>
								<option>Select Income</option>
								<option value="Below $1000" <?php if(@$user->income=="Below $1000"){ echo "selected" ;} ?>>Below $1000</option>
								<option value="$1001-$3000" <?php if(@$user->income=="$1001-$3000"){ echo "selected" ;} ?>>$1001-$3000</option>
								<option value="$3001-$5000" <?php if(@$user->income=="$3001-$5000"){ echo "selected" ;} ?>>$3001-$5000</option>
								<option value="$5000 and above" <?php if(@$user->income=="$5000 and above"){ echo "selected" ;} ?>>$5000 and above</option>
								</select>
							</div>
						</div>

						<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
							<div class="panel-title">Mobile No</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
							<div class="panel-body" style="display: block;">
								<p>User's Mobile No</p>
								<input type="text" class="form-control" name="mobile" id="mobile" value="<?php if(!empty($user->mobile)): ?><?= $user->mobile ?><?php endif; ?>" />
							</div>
						</div>

						<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
							<div class="panel-title">No of Household</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
							<div class="panel-body" style="display: block;">
								<p>User's No of Household</p>
								<input type="text" class="form-control" name="nohouse" id="nohouse" value="<?php if(!empty($user->nohouse)): ?><?= $user->nohouse ?><?php endif; ?>" />
							</div>
						</div>

						<div class="row">

							<div class="col-sm-4">
								<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
									<div class="panel-title">User Role</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
									<div class="panel-body" style="display: block;">
									<p>Select the user's role below</p>
										<select  class="form-control" id="role" name="role">
											<option value="admin" @if(isset($user->role) && $user->role == 'admin')selected="selected"@endif>Admin</option>
											<option value="demo" @if(isset($user->role) && $user->role == 'demo')selected="selected"@endif>Demo</option>
											<option value="registered" @if(isset($user->role) && $user->role == 'registered')selected="selected"@endif>Registered Users (free registration must be enabled)</option>
											<option value="subscriber" @if(isset($user->role) && $user->role == 'subscriber')selected="selected"@endif>Subscriber</option>
										</select>
									</div>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
									<div class="panel-title">User Active Status</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
									<div class="panel-body" style="display: block;">
										<label>User Active Status </label>
										<input type="checkbox" id="active" name="active" @if(isset($user->active) && $user->active == 1)checked="checked" value="1" @else value="0" @endif />
									</div>
								</div>
							</div>

							{{--<div class="col-sm-3">--}}
								{{--<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">--}}
									{{--<div class="panel-title">Corporate User</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>--}}
									{{--<div class="panel-body" style="display: block;">--}}
										{{--<label>Corporate User </label>--}}
										{{--<input type="checkbox"  name="corporate_user" value="1" />--}}
										{{--<p>Select the user's coporate role below</p>--}}
										{{--<select  class="form-control" id="corporate_user" name="corporate_user">--}}
											{{--<option value="" @if(isset($user->corporate_user) && $user->corporate_user == '')selected="selected"@endif>No Coporate User</option>--}}
											{{--<option value="Corporate_User" @if(isset($user->corporate_user) && $user->corporate_user == 'Corporate_User')selected="selected"@endif>Coporate User</option>--}}
											{{--<option value="Corporate_Admin" @if(isset($user->corporate_user) && $user->corporate_user == 'Corporate_Admin')selected="selected"@endif>Corporate Admin</option>--}}
											{{--<option value="1" @if(isset($user->corporate_user) && $user->corporate_user == '1')selected="selected"@endif>True</option>--}}
											{{--<option value="0" @if(isset($user->corporate_user) && $user->corporate_user == '0')selected="selected"@endif>False</option>--}}
										{{--</select>--}}
									{{--</div>--}}
								{{--</div>--}}
							{{--</div>--}}

							<div class="col-sm-4">
								<div class="panel panel-primary" data-collapsed="0">
									<div class="panel-heading">
										<div class="panel-title">Contribute</div>
										<div class="panel-options">
											<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
										</div>
									</div>
									<div class="panel-body" style="display: block;">
										{{--<label>Contribute </label>--}}
										{{--<input type="checkbox"  name="contribute" value="1" />--}}
										<p>Select the user's contribute role below</p>
										<select  class="form-control" id="contribute" name="contribute">
											<option value="" @if(isset($user->corporate_user) && $user->corporate_user == '')selected="selected"@endif>No Contribute User</option>
											<option value="contribute" @if(isset($user->corporate_user) && $user->corporate_user == 'Corporate_User')selected="selected"@endif>Contribute User</option>
										</select>
									</div>
								</div>
							</div>



						</div><!-- row -->

						@if($id = $user->id)
							<input type="hidden" id="id" name="id" value="{{ $id }}" />
						@endif

						<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
						<input type="submit" value="{{ $button_text }}" class="btn btn-success pull-right" />

						<div class="clear"></div>
					</form>

				</div>
		  </div>




		<div class="clear"></div>
<!-- This is where now -->
</div>




	@section('javascript')


	<script type="text/javascript" src="{{ '/hellovideo/application/application/assets/js/tinymce/tinymce.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/hellovideo/application/application/assets/js/tagsinput/jquery.tagsinput.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/hellovideo/application/application/assets/js/jquery.mask.min.js' }}"></script>

	<script type="text/javascript">

	$ = jQuery;

	$(document).ready(function(){

		$('#active, #disabled').change(function() {
			if($(this).is(":checked")) {
		    	$(this).val(1);
		    } else {
		    	$(this).val(0);
		    }
		    console.log('test ' + $(this).is( ':checked' ));
		});

	});



	</script>

	@stop

@stop
