
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
<style>
.center-cropped {
  width: 1200px;
  height: 500px;
  background-position: center center;
  background-repeat: no-repeat;
}
</style>
<article class="block" id="item">
    <?php $title=strtolower($video->title);
        $category = '';
        foreach($video_categories as $cate) {
           if($cate->id == $video->video_category_id ) {
               $category = $cate->name ;
               break;
            }
        }
    ?>
	<!--<a class="block-thumbnail" href="<?//= ($settings->enable_https) ? secure_url('video') : URL::to('video'); ?><?//= '/'. $video->id . '/' .$string = str_replace(' ','-', $title); ?>">-->
    <a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('videos') : URL::to('videos'); ?><?= '/'. $string = str_replace(' ','-', $category) . '/' .$string = str_replace(' ','-', $title); ?>">
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
		<div class="item-overlay top"></div>

		<div class="details" >
			<span style="font-size:16px; margin-top: -3px; float:left; font-weight: normal; padding-left:15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width:70%;" ><?= $video->title; ?></span>
			<span><?= HelloVideo\Libraries\TimeHelper::convert_seconds_to_HMS($video->duration); ?></span>
		</div>
	</a>


</article>
