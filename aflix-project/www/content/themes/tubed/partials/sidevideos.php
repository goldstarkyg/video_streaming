<article class="block" id="">
    <?php $title=strtolower($video->title);?>
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
