@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ '/application/assets/js/tagsinput/jquery.tagsinput.css' }}" />
@stop


@section('content')

<div id="admin-container">
<!-- This is where -->

	<div class="admin-section-title">

		<h3><i class="entypo-user"></i>Add Bulk User</h3>

	</div>
	<div class="clear"></div>



		<form method="POST" action="add_file" id="update_profile_form" accept-charset="UTF-8" file="1" enctype="multipart/form-data">



			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
				<div class="panel-title">Select CSV File</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block;">


					<input type="file" name="data" class="form-controll" required>
					<input type="hidden" name="role" value="admin">
					<?php @$p=Auth::user()->id;?>
					<input type="hidden" name="user_id" value="<?php echo $p;?>">
				</div>
			</div>

















			<div class="row">

				<!--<div class="col-sm-4">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
						<div class="panel-title">User Role</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body" style="display: block;">
						<p>Select the user's role below</p>
							<select id="role" name="role">
								<option value="admin" @if(isset($user->role) && $user->role == 'admin')selected="selected"@endif>Admin</option>
								<option value="demo" @if(isset($user->role) && $user->role == 'demo')selected="selected"@endif>Demo</option>
								<option value="registered" @if(isset($user->role) && $user->role == 'registered')selected="selected"@endif>Registered Users (free registration must be enabled)</option>
								<option value="subscriber" @if(isset($user->role) && $user->role == 'subscriber')selected="selected"@endif>Subscriber</option>
							</select>
						</div>
					</div>
				</div>-->





			</div><!-- row -->



			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="Upload" class="btn btn-success pull-right" />

			<div class="clear"></div>
		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>




	@section('javascript')


	<script type="text/javascript" src="{{ '/application/assets/js/tinymce/tinymce.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/application/assets/js/tagsinput/jquery.tagsinput.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/application/assets/js/jquery.mask.min.js' }}"></script>

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
