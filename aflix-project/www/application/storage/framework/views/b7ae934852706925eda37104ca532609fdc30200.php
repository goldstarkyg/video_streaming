<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/css/sweetalert.css'); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-video"></i> Videos</h3><a href="<?php echo e(URL::to('admin/videos/create')); ?>" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
			<div class="col-md-4">
				<form method="get" role="form" class="search-form-full">
					<div class="form-group">
						<input type="text" class="form-control" value="<?= request('s'); ?>" name="s" id="search-input" placeholder="Search...">
						<i class="entypo-search"></i>
					</div>
					<hr />
					<div class="form-group" >
						<select class="form-control" name="published">
							<option value="0" <?php echo e((request('published') == 0) ? 'selected' : ''); ?>>All</option>
							<option value="1" <?php echo e((request('published') == 1) ? 'selected' : ''); ?>>Published</option>
							<option value="2" <?php echo e((request('published') == 2) ? 'selected' : ''); ?>>Unpublished</option>
						</select>
					</div>
					<hr />
					<div class="form-group" >
						<select class="form-control" name="corp_admin">
							<<option value="0"> Select Corporate Admin </option>
							<?php $__currentLoopData = $corps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $corp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							  <option value="<?php echo e($corp->id); ?>" <?php echo e((request('corp_admin') == $corp->id ) ? 'selected' : ''); ?>><?php echo e($corp->username); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</div>
					<hr />

					<button type="submit" class="btn btn-default" role="button">Search</button>
				</form>
			</div>
		</div>
	</div>
	<div class="clear"></div>

	<div class="gallery-env">

		<div class="row">

		<?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

			<div class="col-sm-6 col-md-3">

				<article class="album">

					<header>
						<?php $title=strtolower($video->title);?>
						<?php $string = str_replace(' ','-', $title); ?>
						<a href="<?php echo e(URL::to('video/') . '/' . $video->id . '/' . $string); ?>" target="_blank">
							<img src="<?php echo e(Config::get('site.uploads_dir') . 'images/' . $video->image); ?>" />
						</a>

						<a href="<?php echo e(URL::to('admin/videos/edit') . '/' . $video->id); ?>" class="album-options">
							<i class="entypo-pencil"></i>
							Edit
						</a>
					</header>

					<section class="album-info">
						<h3><a href="<?php echo e(URL::to('admin/videos/edit') . '/' . $video->id); ?>"><?php if(strlen($video->title) > 25){ echo substr($video->title, 0, 25) . '...'; } else { echo $video->title; } ?></a></h3>

						<p><?php echo e($video->description); ?></p>
					</section>

					<footer>
						<div class="album-options">
						<?php
						if($video->access=="subscriber")
						{
						?>
						<a href="" class="btn btn-info btn-lg" data-toggle="modal" data-target="#<?php echo $video->id;?>1" style="background: #5c9403;color: #ffffff; font-size: 12px;">
								<i class="fa fa-plus-circle"></i>Assign To
							</a>
							<?php
						}
							?>
						<?php
						if($video->active==0 || empty($video->active))
						{
						?>
						<a href="videos/<?php echo $video->id?>/publish" class="btn btn-info btn-lg" style="background: #5c9403;color: #ffffff; font-size: 12px;">
								<i class="fa fa-plus-circle"></i>Publish
							</a>
						<?php
						}
						else
						{
						?>
						<a href="videos/<?php echo $video->id?>/unpublish" class="btn btn-info btn-lg" style="background: #cc2424;color: #ffffff; font-size: 12px;">
								<i class="fa fa-plus-circle"></i>Un Publish
							</a>
						<?php
						}
						?>
						<?php
						if($video->live!="live")
						{
								if($video->ads==null)
								{
								?>
									<a href="" class="btn btn-info btn-lg" data-toggle="modal" data-target="#<?php echo $video->id;?>" style="background: #5c9403;color: #ffffff; font-size: 12px;">
											<i class="fa fa-plus-circle"></i>Apply Ads
									</a>
								<?php
								}
								else
								{
								?>
									<a href="" class="btn btn-info btn-lg" data-toggle="modal" data-target="#<?php echo $video->id;?>" style="background: #5c9403;color: #ffffff; font-size: 12px;">
											<i class="fa fa-plus-circle"></i>Update Ads
									</a>
									<a href="videos/ad/<?= $video->id ?>/disable" class="btn btn-info btn-lg" style="background: #cc2424;color: #ffffff; font-size: 12px;">
											<i class="fa fa-plus-circle"></i>Disable Ad
										</a>
									<?php
								}
						}
						?>

							<a href="<?php echo e(URL::to('admin/videos/edit') . '/' . $video->id); ?>">
								<i class="entypo-pencil"></i>
							</a>

							<a href="<?php echo e(URL::to('admin/videos/delete') . '/' . $video->id); ?>" class="delete">
								<i class="entypo-trash"></i>
							</a>
						</div>

					</footer>

				</article>

			</div>
			<div class="modal fade" id="<?php echo $video->id;?>" role="dialog">
				<div class="modal-dialog">

				  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <?php
					  if($video->ads==null)
					  {
					  ?>
					 	 <h4 class="modal-title">Apply Ads</h4>
					  <?php
					  }
					  else
					  {
					  ?>
					  	<h4 class="modal-title">Update Ads</h4>
					  <?php
					  }
					  ?>
					</div>
					<form method="post" action="videos/post_add">
					<input type="hidden" name="id" value="<?php echo $video->id;?>">
					<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
					<div class="modal-body">
					<?php
					if($video->embed_code==null)
					{
					?>
					  <select name="ads" class="form-control">
					  <?php
					  $ads=DB::select("select * FROM add_ads");
					  foreach($ads as $ad)
					  {
					  ?>
					  <option value="<?php echo $ad->id;?>"><?php echo $ad->title;?></option>
					  <?php
					  }
					  ?>
					  </select>
					  <?php
					}
					else
					{
					  ?>
					  <select name="ads" class="form-control">
					  <?php
					  $ads=DB::select("select * FROM add_ads");
					  foreach($ads as $ad)
					  {
					  ?>
					  <option value="<?php echo $ad->id;?>"><?php echo $ad->title;?></option>
					  <?php
					  }
					  ?>
					  </select>
					  <?php
					}
					  ?>
					  <br>
					<input type="submit" value="Submit" class="btn btn-success pull-right" />
					</div>
					</form>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>

				</div>
			 </div>

  			 <div class="modal fade" id="<?php echo $video->id;?>1" role="dialog">
				<div class="modal-dialog">

				  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>

					  <h4 class="modal-title">Assign To</h4>

					</div>
					<form method="post" action="videos/assignto">
					<input type="hidden" name="id" value="<?php echo $video->id;?>">

					<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
					<div class="modal-body">

					  <select name="user[]" class="form-control" multiple="multiple" style="height: 150px;">
					  <?php
					  $ads=DB::select("select * FROM users where corporate_user='Corporate_Admin' or corporate_user='Corporate_User' order by username ");
					  foreach($ads as $ad)
					  {
						  $as_user=DB::select("select * FROM assignto where user_id='".$ad->id."' and video_id='".$video->id."' ");
						  $select_user = '';
						  if(!empty($as_user)) $select_user='selected';
					  ?>
					  <option value="<?php echo $ad->id;?>" <?php echo $select_user ?> ><?php echo $ad->username;?></option>
					  <?php
					  }
					  ?>
					  </select>

					  <br>
					<input type="submit" value="Submit" class="btn btn-success pull-right" />
					</div>
					</form>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>

				</div>
			  </div>

		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

		<div class="clear"></div>

		<div class="pagination-outter"><?= $videos->appends(Request::only('s' , 'corp_admin' , 'published'))->render(); ?></div>

		</div>

	</div>


	<?php $__env->startSection('javascript'); ?>
	<script src="<?php echo e('/application/assets/admin/js/sweetalert.min.js'); ?>"></script>
	<script>

		$(document).ready(function(){
			var delete_link = '';

			$('.delete').click(function(e){
				e.preventDefault();
				delete_link = $(this).attr('href');
				swal({   title: "Are you sure?",   text: "Do you want to permanantly delete this video?",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){    window.location = delete_link });
			    return false;
			});
		});

	</script>



	<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>