<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" href="<?php echo e('/application/assets/js/tagsinput/jquery.tagsinput.css'); ?>" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<div id="admin-container">
<!-- This is where -->

	<ol class="breadcrumb"> <li> <a href="#"><i class="fa fa-newspaper-o"></i>Manage Revenue</a> </li> <li class="active"> <strong></strong>  <strong>New  Revenue</strong></li> </ol>

	<div class="admin-section-title">

		<h3></h3>


		<h3><i class="entypo-plus"></i> Manage <?php echo e(($user) ? '' : 'Default'); ?> Revenue</h3>

	</div>
	<div class="clear"></div>

		<form method="POST" action="/admin/manage/edit_revenue" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

			<div class="row">
					<input type="hidden" value="<?php echo e(($user) ? $user->id : 0); ?>" name="user_id">
				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
				<div class="panel-title">Revenue For Premium Video ( Contributor )</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block; padding:0px;">
					<input type="text" class="form-control" placeholder="Enter Revenue For Premium Video"
					value="<?php echo e(($user) ? $user->countribute->premium_video : $defaults->premium_video); ?>" name="premium_video" />
				</div>

				</div>

				<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
				<div class="panel-title">Revenue For Subscribe Video ( Contributor )</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block; padding:0px;">
					<input type="text" class="form-control" placeholder="Enter Revenue For Subscribe Video"
					value="<?php echo e(($user) ? $user->countribute->subscribe_video : $defaults->subscribe_video); ?>" name="subscribe_video" />
				</div>

				</div>

			</div>


			<!--<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
				<div class="panel-title">Post Content</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block; padding:0px;">
					<textarea class="form-control" name="body" id="body"><?php if(!empty($post->body)): ?><?php echo e(htmlspecialchars($post->body)); ?><?php endif; ?></textarea>
				</div>
			</div>--


			<div class="panel panel-primary" id="body_guest_block" style="<?php if(empty($post->access) || $post->access == 'guest'): ?>display:none;<?php endif; ?>" data-collapsed="0"> <div class="panel-heading">
				<div class="panel-title">Content to be shown to non-subscriber (if any)</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block; padding:0px;">
					<textarea class="form-control" name="body_guest" id="body_guest"><?php if(!empty($post->body_guest)): ?><?php echo e(htmlspecialchars($post->body_guest)); ?><?php endif; ?></textarea>
				</div>
			</div>-->

			<div class="clear"></div>


			<div class="row">

				<!--<div class="col-sm-4">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
						<div class="panel-title">Post Image</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body" style="display: block;">
							<?php if(!empty($post->image)): ?>
								<img src="<?php echo e(Config::get('site.uploads_dir') . 'images/' . $post->image); ?>" class="post-img" width="200"/>
							<?php endif; ?>
							<p>Select the post image (1280x720 for best results):</p>
							<input type="file" multiple="true" class="form-control" name="image" id="image" />

						</div>
					</div>
				</div>--

				<div class="col-sm-4">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading">
						<div class="panel-title">Category</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body" style="display: block;">
							<p>Select a Post Category Below:</p>
							<select id="post_category_id" name="post_category_id">
								<option value="0">Uncategorized</option>
								<?php $__currentLoopData = $post_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($category->id); ?>" <?php if(!empty($post->post_category_id) && $post->post_category_id == $category->id): ?>selected="selected"<?php endif; ?>><?php echo e($category->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>
				</div>--

				<div class="col-sm-4">
					<div class="panel panel-primary" data-collapsed="0">
						<div class="panel-heading"> <div class="panel-title"> Status & Access Settings</div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body">
							<div>
								<label for="active" style="float:left; display:block; margin-right:10px;">Is this post Active:</label>
								<input type="checkbox" <?php if(!isset($post->active) || (isset($post->active) && $post->active)): ?>checked="checked" value="1"<?php else: ?> value="0"<?php endif; ?> name="active" id="active" />
								<p class="clear"></p>
								<label for="access" style="float:left; margin-right:10px;">Who is allowed to view this post?</label>
								<select id="access" name="access">
									<option value="guest" <?php if(!empty($post->access) && $post->access == 'guest'): ?><?php echo e('selected'); ?><?php endif; ?>>Guest (everyone)</option>
									<option value="registered" <?php if(!empty($post->access) && $post->access == 'registered'): ?><?php echo e('selected'); ?><?php endif; ?>>Registered Users (free registration must be enabled)</option>
									<option value="subscriber" <?php if(!empty($post->access) && $post->access == 'subscriber'): ?><?php echo e('selected'); ?><?php endif; ?>>Subscriber (only paid subscription users)</option>
								</select>
							</div>
						</div>
					</div>
				</div>-->

			</div><!-- row -->


			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="Update Revenue" class="btn btn-success pull-right" />

		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>




	<?php $__env->startSection('javascript'); ?>


	<script type="text/javascript" src="<?php echo e('/application/assets/admin/js/tinymce/tinymce.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo e('/application/assets/js/jquery.mask.min.js'); ?>"></script>

	<script type="text/javascript">

	$ = jQuery;

	$(document).ready(function(){

		$('#duration').mask('00:00:00');

		$('input[type="checkbox"]').change(function() {
			if($(this).is(":checked")) {
		    	$(this).val(1);
		    } else {
		    	$(this).val(0);
		    }
		    console.log('test ' + $(this).is( ':checked' ));
		});

		$('#access').change(function() {
			if($(this).val() == 'guest'){
				$('#body_guest_block').slideUp();
			} else {
				$('#body_guest_block').slideDown();
			}
		});

		tinymce.init({
			relative_urls: false,
		    selector: '#body, #body_guest',
		    toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
		    plugins: [
		         "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
		         "save table contextmenu directionality emoticons template paste textcolor code"
		   ],
		   menubar:false,
		 });

	});



	</script>

	<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>