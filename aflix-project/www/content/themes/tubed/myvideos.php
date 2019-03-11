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

<?php include('includes/header.php'); ?>
<?php
if(@$_GET['user_id']!=null AND @$_GET['user_id']!=null)
{
$del=DB::select("insert into contribute_deletevideo(user_id,video_id)value('".@$_GET['user_id']."','".@$_GET['id']."')");
$del1=DB::select("update videos set delbycontri=1 where id='".@$_GET['id']."'");
echo "<script>window.location='my_video'</script>";
}
?>
<?php
	@$p1=Auth::user()->role;
	if($p1=="admin")
	{
	?>
	<script>window.location='http://aflix.tv/'</script>
	<?php
	}
	?>

	<h3 class="col-md-10 col-md-offset-2 right-content-10 header"><?php echo "My videos"; ?><?php if(isset($page_description)): ?><span><?= $page_description ?></span><?php endif; ?></h3>


<div class="col-md-offset-2 col-md-10 right-content-10">

		<div class="row">
		 <?php
		 @$p=Auth::user()->id;
							 @$p;
		 @$videos = DB::select("select * from videos where user_id ='$p'");
					foreach ($videos as $video)
					{
					?>
         <div class="col-md-3 col-sm-6 col-xs-12 loop">
		<?php $title=strtolower($video->title);?>
	  <article class="block" id="item">
	<a class="block-thumbnail" href="video/<?= $video->id ?>/<?php echo $string = str_replace(' ','-', $title); ?>">
		<div class="thumbnail-overlay"></div>
		<span class="play-button-small"></span>
		<img src="<?= HelloVideo\Libraries\ImageHandler::getImage(@$video->image)  ?>">
		<div class="details">
			<h2 style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;max-width: 200px;"><?= @$video->title; ?></h2>
			<span><?= HelloVideo\Libraries\TimeHelper::convert_seconds_to_HMS(@$video->duration); ?></span>
		</div>
	</a>
	<div class="block-contents" style="width:50%;">
		<!--<a href="<?= ($settings->enable_https) ? secure_url('video') : URL::to('video'); ?><?= '/' . @$video->id ?>"><?= $string = str_replace(' ','-', $title); ?></a>
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
	<?php
	@$p1=Auth::user()->role;
	if($p1!="admin")
	{
	?>
	<div class="block-contents" style="width:50%; ">
	<a href="edit_video?id=<?php echo $video->id;?>" style="float:right; background-color: #797b74;
    padding: 5px;">Edit</a>
	&nbsp;&nbsp;&nbsp;
	<a class="delete2" href="?id=<?php echo $video->id;?>&user_id=<?php echo $video->user_id;?>" style="float:right; background-color: #e52d27;;
    padding: 5px;">Delete</a>
	</div>

	<?php
	}
	?>
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
<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete2').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to Send Request Admin For Delete this Video?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>

	<?php //include('partials/pagination.php'); ?>

</div>


<?php include('includes/footer.php'); ?>
