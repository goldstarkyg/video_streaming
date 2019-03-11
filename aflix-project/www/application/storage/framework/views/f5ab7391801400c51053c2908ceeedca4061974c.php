<div id="laravelista-comments"></div>

<script>
window.Laravelista = {
    // Eg. App\Post::class || App\\Post
    content_type: "<?php echo e(str_replace('\\', '\\\\', $content_type)); ?>",
    // Eg. 1
    content_id: "<?php echo e($content_id); ?>",
    login_path: "<?php echo e(config('comments.login_path')); ?>"
};
</script>

<script src="<?php echo e(asset('vendor/comments/js/comments-react.js')); ?>"></script>
