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

  border: 1px solid #333;

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
	<h3 class="col-md-10 col-md-offset-2 right-content-10 header"><?php echo "All videos "; ?><?php if(isset($page_description)): ?><span><?= $page_description ?></span><?php endif; ?></h3>


<div class="col-md-offset-2 col-md-10 right-content-10">

		<div class="row">
		 <?php
		 @$p=Auth::user()->id;
							 @$p;
		if(@$_GET['type']=="subscriber")
         {
		 @$videos = DB::select("select * from videos where access='".$_GET['type']."' AND active=1 order by id DESC");
		 }
		 elseif(@$_GET['type']=="premium")
		 {
		  @$videos = DB::select("select * from videos where access='".$_GET['type']."' AND active=1 order by id DESC");
		 }
		 elseif(@$_GET['type']=="registered")
		 {
		  @$videos = DB::select("select * from videos where access='".$_GET['type']."' AND active=1 order by id DESC");
		 }
		 elseif(@$_GET['category']!="")
		 {
		  @$videos = DB::select("select * from videos where video_category_id='".$_GET['category']."' AND active=1 order by id DESC");
		 }
		 else
		 {
		 @$videos = DB::select("select * from videos where active=1  order by id DESC");
		 }
					foreach ($videos as $video)
					{
					?>
         <div class="col-md-3 col-sm-2 col-xs-6 loop" style="padding-left:5px; padding-right:5px;">
		<?php $title=strtolower($video->title);?>
	  <article class="block" id="item">
	<a class="block-thumbnail" href="/video/<?= $video->id ?>/<?php echo $string = str_replace(' ','-', $title);?>">
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
			<h2 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width:70%;"><?= @$video->title; ?></h2>
			<span><?= HelloVideo\Libraries\TimeHelper::convert_seconds_to_HMS(@$video->duration); ?></span>
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
