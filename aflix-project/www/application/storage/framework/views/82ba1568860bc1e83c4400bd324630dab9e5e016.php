<?php $__env->startSection('css'); ?>
	<style type="text/css">
	.make-switch{
		z-index:2;
	}
	</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div id="admin-container">
<!-- This is where -->

	<div class="admin-section-title">
		<h3><i class="entypo-globe"></i> Site Settings</h3>
	</div>
	<div class="clear"></div>



	<form method="POST" action="<?php echo e(URL::to('admin/settings')); ?>" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

		<div class="row">

			<div class="col-md-4">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
					<div class="panel-title">Site Name</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body" style="display: block;">
						<p>Enter Your Website Name Below:</p>
						<input type="text" class="form-control" name="website_name" id="website_name" placeholder="Site Title" value="<?php if(!empty($settings->website_name)): ?><?php echo e($settings->website_name); ?><?php endif; ?>" />
					</div>
				</div>
			</div>

			<div class="col-md-8">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
					<div class="panel-title">Site Description</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body" style="display: block;">
						<p>Enter Your Website Description Below:</p>
						<input type="text" class="form-control" name="website_description" id="website_description" placeholder="Site Description" value="<?php if(!empty($settings->website_description)): ?><?php echo e($settings->website_description); ?><?php endif; ?>" />
					</div>
				</div>
			</div>

		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
			<div class="panel-title">Logo</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
			<div class="panel-body" style="display: block; background:#f1f1f1;">
				<?php if(!empty($settings->logo)): ?>
					<img src="<?php echo e(Config::get('site.uploads_dir') . 'settings/' . $settings->logo); ?>" style="max-height:100px" />
				<?php endif; ?>
				<p>Upload Your Site Logo:</p>
				<input type="file" multiple="true" class="form-control" name="logo" id="logo" />

			</div>
		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
			<div class="panel-title">Favicon</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
			<div class="panel-body" style="display: block;">
				<?php if(!empty($settings->favicon)): ?>
					<img src="<?php echo e(Config::get('site.uploads_dir') . 'settings/' . $settings->favicon); ?>" style="max-height:20px" />
				<?php endif; ?>
				<p>Upload Your Site Favicon:</p>
				<input type="file" multiple="true" class="form-control" name="favicon" id="favicon" />

			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title">Demo Mode</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body">
						<p>Enable Demo Account:</p>

						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" <?php if(!isset($settings->demo_mode) || (isset($settings->demo_mode) && $settings->demo_mode)): ?>checked="checked" value="1"<?php else: ?> value="0"<?php endif; ?> name="demo_mode" id="demo_mode" />
				            </div>
						</div>

					</div>
				</div>

			</div>
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title">Enable https:// sitewide</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body">
						<p>Make sure you have purchased an SSL before anabling https://</p>
						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" <?php if(!isset($settings->enable_https) || (isset($settings->enable_https) && $settings->enable_https)): ?>checked="checked" value="1"<?php else: ?> value="0"<?php endif; ?> name="enable_https" id="enable_https" />
				            </div>
						</div>
					</div>
				</div>
			</div>

		</div>


		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title">Videos Per Page</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body">
						<p>Default number of videos to show per page:</p>
						<input type="text" class="form-control" name="videos_per_page" id="videos_per_page" placeholder="# of Videos Per Page" value="<?php if(!empty($settings->videos_per_page)): ?><?php echo e($settings->videos_per_page); ?><?php endif; ?>" />
					</div>
				</div>

			</div>
			<div class="col-sm-6">
				<div class="panel panel-primary" data-collapsed="0">
					<div class="panel-heading"> <div class="panel-title">Posts Per Page</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
					<div class="panel-body">
						<p>Default number of posts to show per page:</p>
						<input type="text" class="form-control" name="posts_per_page" id="posts_per_page" placeholder="# of Posts Per Page" value="<?php if(!empty($settings->posts_per_page)): ?><?php echo e($settings->posts_per_page); ?><?php endif; ?>" />
					</div>
				</div>
			</div>

		</div>

		<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading"> <div class="panel-title">Registration</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4 align-center">
						<p>Enable Free Registration:</p>

						<div class="form-group">
				        	<div class="make-switch" data-on="success" data-off="warning">
				                <input type="checkbox" <?php if(!isset($settings->free_registration) || (isset($settings->free_registration) && $settings->free_registration)): ?>checked="checked" value="1"<?php else: ?> value="0"<?php endif; ?> name="free_registration" id="free_registration" />
				            </div>
						</div>
					</div>


				</div>

			</div>
		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
			<div class="panel-title">System Email</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
			<div class="panel-body" style="display: block;">
				<p>Email address to be used to send system emails:</p>
				<input type="text" class="form-control" name="system_email" id="system_email" placeholder="Email Address" value="<?php if(!empty($settings->system_email)): ?><?php echo e($settings->system_email); ?><?php endif; ?>" />
			</div>
		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
			<div class="panel-title">Social Networks</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
			<div class="panel-body" style="display: block;">

				<p>Facebook Page ID: ex. facebook.com/page_id (without facebook.com):</p>
				<input type="text" class="form-control" name="facebook_page_id" id="facebook_page_id" placeholder="Facebook Page" value="<?php if(!empty($settings->facebook_page_id)): ?><?php echo e($settings->facebook_page_id); ?><?php endif; ?>" />
				<br />
				<p>Google Plus User ID:</p>
				<input type="text" class="form-control" name="google_page_id" id="google_page_id" placeholder="Google Plus Page" value="<?php if(!empty($settings->google_page_id)): ?><?php echo e($settings->google_page_id); ?><?php endif; ?>" />
				<br />
				<p>Twitter Username:</p>
				<input type="text" class="form-control" name="twitter_page_id" id="twitter_page_id" placeholder="Twitter Username" value="<?php if(!empty($settings->twitter_page_id)): ?><?php echo e($settings->twitter_page_id); ?><?php endif; ?>" />
				<br />
				<p>YouTube Channel ex. youtube.com/channel_name:</p>
				<input type="text" class="form-control" name="youtube_page_id" id="youtube_page_id" placeholder="YouTube Channel" value="<?php if(!empty($settings->youtube_page_id)): ?><?php echo e($settings->youtube_page_id); ?><?php endif; ?>" />

			</div>
		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
			<div class="panel-title">Google Analytics Tracking ID</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
			<div class="panel-body" style="display: block;">

				<p>Google Analytics Tracking ID (ex. UA-12345678-9)::</p>
				<input type="text" class="form-control" name="google_tracking_id" id="google_tracking_id" placeholder="Google Analytics Tracking ID" value="<?php if(!empty($settings->google_tracking_id)): ?><?php echo e($settings->google_tracking_id); ?><?php endif; ?>" />

			</div>
		</div>

		<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
			<div class="panel-title">Google Analytics API Integration (This will integrate with your dashboard analytics)</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
			<div class="panel-body" style="display: block;">

				<p>Google Oauth Client ID Key:</p>
				<input type="text" class="form-control" name="google_oauth_key" id="google_oauth_key" placeholder="Google Client ID Key" value="<?php if(!empty($settings->google_oauth_key)): ?><?php echo e($settings->google_oauth_key); ?><?php endif; ?>" />


			</div>
		</div>

		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<input type="submit" value="Update Settings" class="btn btn-success pull-right" />

	</form>

	<div class="clear"></div>

</div><!-- admin-container -->

<?php $__env->startSection('javascript'); ?>
	<script src="<?php echo e('/application/assets/admin/js/bootstrap-switch.min.js'); ?>"></script>
	<script type="text/javascript">

		$ = jQuery;

		$(document).ready(function(){

			$('input[type="checkbox"]').change(function() {
				if($(this).is(":checked")) {
			    	$(this).val(1);
			    } else {
			    	$(this).val(0);
			    }
			});

			$('#free_registration').change(function(){
				if($(this).is(":checked")) {
					$('#activation_email_block').fadeIn();
					$('#premium_upgrade_block').fadeIn();
				} else {
					$('#activation_email_block').fadeOut();
					$('#premium_upgrade_block').fadeOut();
				}
			});

		});

	</script>

<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>