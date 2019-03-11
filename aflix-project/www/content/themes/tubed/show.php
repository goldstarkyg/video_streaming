<?php include('includes/header.php'); ?>


<style>
* {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

#item {
  position: relative;



  overflow: hidden;

}
#item img {
  max-width: 100%;

  -moz-transition: all 0.3s;
  -webkit-transition: all 0.3s;
  transition: all 0.3s;
}
#item:hover img {
  -moz-transform: scale(1.1);
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>
<style>
article {
    width: 100%;

    background-repeat: no-repeat;
    background-size: contain;
    border:0px;
}

</style>
	<h3 class="col-md-10 col-md-offset-2 right-content-10 header"><?php echo "Shows"; ?><?php if(isset($page_description)): ?><span><?= $page_description ?></span><?php endif; ?></h3>


<div class="col-md-offset-2 col-md-10 right-content-10">

		<div class="row">
		 <?php

		 @$videos = HelloVideo\Models\VideoCategory::all();

					foreach ($videos as $video)
					{
					?>
         <div class="col-md-3 col-sm-6 col-xs-12 loop">

	  <article class="block" id="item">
    <?php $title=strtolower($video->slug);?>
	<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('video') : URL::to('video'); ?><?= '/'. $video->id . '/' .$string = str_replace(' ','-', $title); ?>">
		<div class="thumbnail-overlay"></div>
		<span class="play-button-small"></span>

		<?php
		if($video->bannerImg=='')
		{
		?>
		<img class="center-cropped" src="<?= HelloVideo\Libraries\ImageHandler::getImage($video->image,'small')  ?>">
		<?php
		}
		else
		{
		?>
		<img class="center-cropped" src="/content/uploads/file/<?= $video->bannerImg;  ?>">
		<?php
		}
		?>
		<div class="details" >
			<span style="font-size:14px; margin-top: -2px; float:left; font-weight: normal; padding-left:6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;" ><?= $video->title; ?></span>
			<span><?= HelloVideo\Libraries\TimeHelper::convert_seconds_to_HMS($video->duration); ?></span>
		</div>
	</a>


</article>

	</div>

<?php
}
?>
		</div>


	<?php //include('partials/pagination.php'); ?>

</div>


<?php include('includes/footer.php'); ?>
