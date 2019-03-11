<?php $__env->startSection('content'); ?>
<?php
@$id=@$_GET['id'];
if($id!="")
{
$users = DB::select("delete from contributer_tb where id='$id'");
}
?>
	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-newspaper"></i> Contributor Revenue</h3>
			</div>
		</div>
	</div>
	<div class="clear"></div>


<h4>Default Revenue Share For all</h4>
	<table class="table table-striped pages-table">
		<tr class="table-header">
			<th>Revenue For Premium Video</th>
			<th>Revenue For Subscribe Video</th>

			<th>Actions</th>
				<tr>
					<td><?php echo e($defaults->premium_video); ?>%</td>
					<td><?php echo e($defaults->subscribe_video); ?>%</td>
					<td>
						<p>
							<a href="/admin/manage/edit?id=0" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</a>
						</p>
					</td>
				</tr>

	</table>


<hr />

<h4>Special Revenue Share</h4>


	<table class="table table-striped pages-table">
		<tr class="table-header">
			<th>
				User Name
			</th>
			<th>Revenue For Premium Video</th>
			<th>Revenue For Subscribe Video</th>

			<th>Actions</th>

       <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td> <?php echo e($user->username); ?> </td>
					<td><?php echo e($user->countribute->premium_video); ?>%</td>
					<td><?php echo e($user->countribute->subscribe_video); ?>%</td>
					<td>
						<p>
							<a href="/admin/manage/edit?id=<?php echo $user->id;?>" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</a>
							<a href="/admin/manage/delete?id=<?php echo $user->id;?>" class="btn btn-xs btn-danger delete"><span class="fa fa-trash"></span> Delete</a>
						</p>
					</td>
				</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	</table>

	<div class="clear"></div>

	<div class="pagination-outter"></div>

	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this page?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>