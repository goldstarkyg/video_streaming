<?php include('includes/header.php'); ?>


	<h3 class="col-md-10 col-md-offset-2 right-content-10 header"><?php echo "My videos"; ?><?php if(isset($page_description)): ?><span><?= $page_description ?></span><?php endif; ?></h3>


<div class="col-md-offset-2 col-md-10 right-content-10">

		<div class="row">
		 <?php
		 @$p=@$_GET['id'];
							 @$p;
		 @$videos = DB::select("select * from videos where user_id ='$p'");
					foreach ($videos as $video) 
					{
					?>
         <div class="col-md-3 col-sm-6 col-xs-12 loop">
		
	  <article class="block">
	<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('video') : URL::to('video'); ?><?= '/' . @$video->id ?>">
		<div class="thumbnail-overlay"></div>
		<span class="play-button-small"></span>
		<img src="<?= HelloVideo\Libraries\ImageHandler::getImage(@$video->image, 'medium')  ?>">
		<div class="details">
			<h2><?= @$video->views; ?> View<?php if(@$video->views != 1): ?>s<?php endif; ?></h2>
			<span><?= HelloVideo\Libraries\TimeHelper::convert_seconds_to_HMS(@$video->duration); ?></span>
		</div>
	</a>
	<div class="block-contents" style="width:50%;">
		<a href="<?= ($settings->enable_https) ? secure_url('video') : URL::to('video'); ?><?= '/' . @$video->id ?>"><?= @$video->title; ?></a>
		<?php if(@$video->access == 'guest'): ?>
			<span class="type">Free Video</span>
		<?php elseif(@$video->access == 'subscriber'): ?>
			<span class="type">Subscribers Only</span>
		<?php elseif(@$video->access == 'registered'): ?>
    		<span class="type">Registered Users</span>
			<?php elseif(@$video->access == 'premium'): ?>
    		<span class="type">Premium Video</span>
		<?php endif; ?>
		<p class="desc"><?php if(strlen(@$video->description) > 90){ echo substr(@$video->description, 0, 78) . '...'; } else { echo @$video->description; } ?></p>
		
	</div>
	<div class="block-contents" style="width:50%; ">
	<a href="" style="float:right;">Edit</a>
	</div>
	<!--p class="type"><?php if(@$video->access == 'guest'): ?>
			<span class="label label-info">Free Video</span>
		<?php elseif(@$video->access == 'subscriber'): ?>
			<span class="label label-success">Subscribers Only</span>
		<?php endif; ?></p-->
</article>

	</div>
			
<?php
}
?>
		</div>


	<?php //include('partials/pagination.php'); ?>

</div>


<?php include('includes/footer.php'); ?>