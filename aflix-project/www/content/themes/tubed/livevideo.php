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

	<h3 class="col-md-10 col-md-offset-2 right-content-10 header"><?php echo "Live videos"; ?><?php if(isset($page_description)): ?><span><?= $page_description ?></span><?php endif; ?></h3>
	<div class="col-md-offset-2 col-md-10 right-content-10">
		<div class="row">
		 <?php

//		 @$videos = DB::select("select * from videos where live ='live' AND active=1");
		 $videos = DB::table('videos as vi')
			 ->join('video_categories as ca', 'vi.video_category_id', '=', 'ca.id')
			 ->where('live', 'live')
			 ->where('video_type', 'live')
			 ->where('active' , '1')
			 ->select(DB::raw('vi.*, ca.name as category_name'))
		 	 ->get();

			foreach ($videos as $video)
			{
			?>
			 <div class="col-md-3 col-sm-6 col-xs-12 loop">

			  <article class="block" id="item">
				<!--<a class="block-thumbnail" href="<? //= ($settings->enable_https) ? secure_url('video') : URL::to('video'); ?><?//= '/' .$string = str_replace(' ','-', $video->title); ?>">-->
				<a class="block-thumbnail" href="<?= ($settings->enable_https) ? secure_url('video') : URL::to('live');?><?= '/'.$string = str_replace(' ','-', $video->category_name)?><?= '/' .$string = str_replace(' ','-', $video->title); ?>">
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
					<div class="details">
						<h2><?= @$video->title; ?></h2>
						<span><?= HelloVideo\Libraries\TimeHelper::convert_seconds_to_HMS(@$video->duration); ?></span>
					</div>
				</a>
				<div class="block-contents" style="width:50%;">
					<!--<a href="<?= ($settings->enable_https) ? secure_url('video') : URL::to('video'); ?><?= '/' . @$video->id ?>"><?= @$video->title; ?></a>
					<?php if(@$video->access == 'guest'): ?>
						<span class="type">Free Video</span>
					<?php elseif(@$video->access == 'subscriber'): ?>
						<span class="type">Subscribers Only</span>
					<?php elseif(@$video->access == 'registered'): ?>
						<span class="type">Registered Users</span>
						<?php elseif(@$video->access == 'premium'): ?>
						<span class="type">Premium Video</span>
					<?php endif; ?>
					<span class="type">Uploaded By :
					<?php
											$uploaded = DB::select("select * from users where id='".$video->user_id."'");
											foreach($uploaded as $upload)
											{

											echo $upload->username;
											}
											?>
					</span>-->
					<!--<p class="desc"><?php if(strlen(@$video->description) > 90){ echo substr(@$video->description, 0, 78) . '...'; } else { echo @$video->description; } ?></p>-->

				</div>
				<div class="block-contents" style="width:50%; ">

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
