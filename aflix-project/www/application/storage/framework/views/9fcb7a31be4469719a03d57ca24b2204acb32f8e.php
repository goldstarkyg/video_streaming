<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" href="<?php echo e('/application/assets/admin/css/sweetalert.css'); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-video"></i> Videos</h3>
			</div>
			<div class="col-md-4">	
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" value="<?= request('s'); ?>" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>

	<div class="gallery-env">
		
		<div class="row">
		<?php
		@$p11=Auth::user()->id;
		$p1=DB::select("select * from assignto where user_id='$p11'");
			$id1="";
			$user1="";
			foreach($p1 as $p2)
			{
				
				
				
			?>
        <?php
		$videos=DB::select("select * from videos where id='".$p2->video_id."'");
		foreach($videos as $video)
		{
		?>
			<div class="col-sm-6 col-md-4">
				
				<article class="album">
					
					<header>
						
						<a href="<?php echo e(URL::to('video/') . '/' . $video->id); ?>" target="_blank">
							<img src="<?php echo e(Config::get('site.uploads_dir') . 'images/' . $video->image); ?>" />
						</a>
						
						
					</header>
					
					<section class="album-info">
						<h3><a href="<?php echo e(URL::to('admin/videos/edit') . '/' . $video->id); ?>"><?php if(strlen($video->title) > 25){ echo substr($video->title, 0, 25) . '...'; } else { echo $video->title; } ?></a></h3>
						
						<p><?php echo e($video->description); ?></p>
					</section>
					
					<footer>
						
						
						
						<div class="album-options">
						
						<a href="#" class="btn btn-info btn-lg" style="background: #5c9403;color: #ffffff; font-size: 12px;">
								<i class="fa fa-plus-circle"></i>Assign By Admin
							</a>
							
						
						
										
							
							
							
							
						</div>
						
					</footer>
					
				</article>
				
			</div>

  
  

		<?php
		}
			}
		?>

		<div class="clear"></div>

		<div class="pagination-outter"><?php // $videos->appends(Request::only('s'))->render(); ?></div>
		
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