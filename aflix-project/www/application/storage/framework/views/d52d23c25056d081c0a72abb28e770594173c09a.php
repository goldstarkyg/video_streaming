<?php $__env->startSection('content'); ?>
	

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

	<script>
		$('#main-admin-content').load('/admin/theme_settings_form', function(){
			$('.color-picker').colorpicker();
		});
	</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>