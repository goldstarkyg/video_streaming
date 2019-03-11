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
		<h3><i class="entypo-user"></i> Add Corporate Admin</h3>
	@endif
	</div>
	<div class="clear"></div>



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
					<?php if($errors->first('username')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button> <strong>Oh snap!</strong> <?= $errors->first('username'); ?></div><?php endif; ?>
					<p>User's First Name</p>
					<input type="text" class="form-control" name="username" id="username" required value="<?php if(!empty($user->username)): ?><?= $user->username ?><?php endif; ?>" />
				    <input type="hidden" name="corporate_user" value="Corporate_Admin">
					 <input type="hidden" name="role" value="admin">
					<?php @$p=Auth::user()->id;?>
					<input type="hidden" name="user_id" value="<?php echo $p;?>">
				</div>
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
				<div class="panel-title">Email</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block;">
					<?php if($errors->first('email')): ?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
								�
							</button>
							<strong>Oh snap!</strong>
							<?= $errors->first('email'); ?>
						</div>
					<?php endif; ?>
					<?php if(session()->has('userExsist')): ?>
						<div class="alert alert-warning">
							<strong>This User Already  {{ $role = session('userExsist')->role }} ,</strong>

							    <strong>Do You want to add him as Corporate Admin</strong>
							    <button type="submit" class="btn btn-success" name="add_as_corp" value="1">Yes</button>


						</div>
					<?php endif; ?>
					<p>User's Email Address</p>
					<input type="text" class="form-control" name="email" id="email" required value="<?php if(!empty($user->email)): ?><?= $user->email ?><?php endif; ?>" />
				</div>
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
				<div class="panel-title">Organization Name</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block;">
					<?php if($errors->first('organization_name')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('organization_name'); ?></div><?php endif; ?>
					<p>User's Organization Name</p>
					<input type="text" class="form-control" name="organization_name" required id="organization_name" />
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
					<input type="password" class="form-control" name="password" required id="password" value="" />
				</div>
			</div>



			@if(isset($user->id))
				<input type="hidden" id="id" name="id" value="{{ $user->id }}" />
			@endif

			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="{{ $button_text }}" class="btn btn-success pull-right" />

			<div class="clear"></div>
		</form>

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
