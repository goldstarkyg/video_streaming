<?php $__env->startSection('content'); ?>

<style>
.img-thumbnail{
	width: 150px;
	height: 150px;
}
</style>

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-12">
				<h3><i class="entypo-archive"></i> Video Categories</h3><a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">New Video Category</h4>
				</div>

				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="<?php echo e(URL::to('admin/videos/categories/store')); ?>" method="post" enctype="multipart/form-data">
				        <label for="name">Enter the new category name below</label>
				        <input name="name" id="name" placeholder="Category Name" class="form-control" value="" /><br />
				        <label for="slug">URL slug (ex. videos/categories/slug-name)</label>
				        <input name="slug" id="slug" placeholder="URL Slug" class="form-control" value="" />
				        <label for="image">Thumbnail</label>
				        <input name="image" id="image" class="form-control" type="file" />
				        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				    </form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-info" id="submit-new-cat">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="update-category">
		<div class="modal-dialog">
			<div class="modal-content">

			</div>
		</div>
	</div>

	<div class="clear"></div>


		<div class="panel panel-primary category-panel" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					Organize the Categories below: (max of 3 levels)
				</div>

				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>


			<div class="panel-body">

				<div id="nestable" class="nested-list dd with-margins">

					<ol class="dd-list">

					<?php $previous_cat = array(); ?>
					<?php $first_parent_id = 0; ?>
					<?php $second_parent_id = 0; ?>
					<?php $depth = 0; ?>
					<?php $__currentLoopData = $video_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

						<?php if( (isset($previous_cat->id) && $category->parent_id == $previous_cat->parent_id) || $category->parent_id == NULL ): ?>
							</li>
						<?php endif; ?>

						<?php if( (isset($previous_cat->parent_id) && $previous_cat->parent_id !== $category->parent_id) && $previous_cat->id != $category->parent_id ): ?>
							<?php if($depth == 2): ?>
								</li></ol>
								<?php $depth -= 1; ?>
							<?php endif; ?>
							<?php if($depth == 1 && $category->parent_id == $first_parent_id): ?>
								</li></ol>
								<?php $depth -= 1; ?>
							<?php endif; ?>

						<?php endif; ?>

						<?php if(isset($previous_cat->id) && $category->parent_id == $previous_cat->id && $category->parent_id !== $previous_cat->parent_id ): ?>
							<?php if($first_parent_id != 0):
								$first_parent_id = $category->parent_id;
							else:
								$second_parent_id = $category->parent_id;
							endif; ?>
							<ol class="dd-list">
							<?php $depth += 1; ?>
						<?php endif; ?>


						<li class="dd-item" data-id="<?php echo e($category->id); ?>">
							<div class="dd-handle">
								<img src="<?php echo e(Config::get('site.uploads_dir') . 'images/' . $category->image); ?>" alt="<?php echo e($category->name); ?>" class="img-thumbnail">
								  <?php echo e($category->name); ?>

									<span class="slug">
										videos/categories/<?php echo e($category->slug); ?>

									</span>
								</div>
							<div class="actions"><a href="/admin/videos/categories/edit/<?php echo e($category->id); ?>" class="edit">Edit</a> <a href="/admin/videos/categories/delete/<?php echo e($category->id); ?>" class="delete">Delete</a></div>

						<?php $previous_cat = $category; ?>

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



					</ol>

				</div>

			</div>

		</div>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />


	<?php $__env->startSection('javascript'); ?>

		<script src="<?php echo e('/application/assets/admin/js/jquery.nestable.js'); ?>"></script>

		<script type="text/javascript">

		jQuery(document).ready(function($){


			$('#nestable').nestable({ maxDepth: 3 });

			// Add New Category
			$('#submit-new-cat').click(function(){
				$('#new-cat-form').submit();
			});

			$('.actions .edit').click(function(e){
				$('#update-category').modal('show', {backdrop: 'static'});
				e.preventDefault();
				href = $(this).attr('href');
				$.ajax({
					url: href,
					success: function(response)
					{
						$('#update-category .modal-content').html(response);
					}
				});
			});

			$('.actions .delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this category?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});

			$('.dd').on('change', function(e) {
    			$('.category-panel').addClass('reloading');
    			$.post('/admin/videos/categories/order', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val()  }, function(data){
    				console.log(data);
    				$('.category-panel').removeClass('reloading');
    			});

			});


		});
		</script>

	<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>