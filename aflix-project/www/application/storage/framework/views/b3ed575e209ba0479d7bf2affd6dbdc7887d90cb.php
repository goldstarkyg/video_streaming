<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Update Category</h4>
</div>

<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="<?php echo e(URL::to('admin/videos/ad/edit') .'/'. $ad->id); ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title </label>
        <input name="title" id="title" placeholder="Category Name" class="form-control" value="<?php echo e($ad->title); ?>" /><br />
        <label for="link">Link</label>
        <input name="link" id="link" placeholder="URL Slug" class="form-control" value="<?php echo e(str_replace('"' , '' , $ad->link)); ?>" />
        <label for="ads_link">Ads Link</label>
        <input name="ads_link" id="ads_link" placeholder="URL Slug" class="form-control" value="<?php echo e($ad->ads_link); ?>" />
		<label for="link">Time ( to Show Skip Button ) (HH:MM:SS)</label>
		<input name="time" id="time" placeholder="time" class="form-control" value="<?php echo e($ad->time); ?>" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<label for="link">Status</label>
		<input type="checkbox" id="status" name="status" <?php if(isset($ad->status) && $ad->status == 1): ?>checked="checked" value="1" <?php else: ?> value="0" <?php endif; ?> />
    </form>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-info" id="submit-update-cat">Update</button>
</div>

<script>
	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
		$('#status').change(function() {
			if($(this).is(":checked")) {
				$(this).val(1);
			} else {
				$(this).val(0);
			}
		});
	});
</script>
