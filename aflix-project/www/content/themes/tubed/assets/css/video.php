<?php include('includes/header.php'); ?>


<div class="col-md-8 col-md-offset-2 right-content-8" id="video_section" style="padding:0px;">

	<div id="video_title">
		<div class="container-fluid">
			<span class="label">You're watching:</span> <h1><?= $video->title ?></h1>
		</div>
	</div>
	<div id="video_bg" style="background-image:url(<?= Config::get('site.uploads_url') . '/images/' . str_replace(' ', '%20', $video->image) ?>)">
		<div id="video_bg_dim" <?php if($video->access == 'guest' || ($video->access == 'subscriber' && !Auth::guest()) ): ?><?php else: ?>class="darker"<?php endif; ?>></div>
		<div class="container-fluid">

			<?php //if($video->access == 'guest' || ( ($video->access == 'subscriber' || $video->access == 'registered') && !Auth::guest() && Auth::user()->subscribed()) || (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) || (!Auth::guest() && $video->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered') ): ?>
                            <?php
							 @$p=Auth::user()->email;
							 @$p;

 $date=date('Y-m-d');
 @$enddate=@Auth::user()->end_plan;
					if($enddate==$date)
					{
					@$users10 = DB::select("update users set role='registered' where email ='$p'");
					}

					@$users = DB::select("select * from premium_video where userid ='$p' AND video_id =".$video->id."");
					$id="";
					$video_type="";
					foreach ($users as $user)
					{
					 $user->video_id;
					 if($id=="")
					 {
					  $id=$user->video_id;
					 }
					 else
					 {
					  $id=$user->video_id;
					 }
					 if($video_type=="")
					 {
					 $video_type=$user->video_type;
					 }
					 else
					 {
					  $video_type=$user->video_type;
					 }
					}

					?>
			<?php if($video->access == 'guest'): ?>

					<?php if($video->type == 'embed'): ?>
						<div id="video_container" class="fitvid">
							<?= $video->embed_code ?>
						</div>
					<?php else: ?>
						<div id="video_container">
						<video id="video_player" class="video-js vjs-default-skin" controls preload="auto" poster="<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>" data-setup="{}" width="100%" style="width:100%;">
							<source src="<?= $video->mp4_url; ?>" type='video/mp4'>
							<source src="<?= $video->webm_url; ?>" type='video/webm'>
							<source src="<?= $video->ogg_url; ?>" type='video/ogg'>
							<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
						</video>
						</div>
					<?php endif; ?>

<?php elseif($video->access == 'registered' && @Auth::user()->role == 'registered'  || ($video->access == 'registered' && @Auth::user()->role == 'subscriber') || $video->access == 'subscriber' && @Auth::user()->role == 'subscriber') : ?>

					<?php if($video->type == 'embed'): ?>
						<div id="video_container" class="fitvid">
							<?= $video->embed_code ?>
						</div>
					<?php else: ?>
						<div id="video_container">
						<video id="video_player" class="video-js vjs-default-skin" controls preload="auto" poster="<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>" data-setup="{}" width="100%" style="width:100%;">
							<source src="<?= $video->mp4_url; ?>" type='video/mp4'>
							<source src="<?= $video->webm_url; ?>" type='video/webm'>
							<source src="<?= $video->ogg_url; ?>" type='video/ogg'>
							<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
						</video>
						</div>
					<?php endif; ?>

 <?php elseif($video->access == 'premium' && @$video_type && (@$video->id == @$id)): ?>

 <?php
 $date=date('Y-m-d');
							 @$p=Auth::user()->email;
							  @$p;
					@$users1 = DB::select("select * from premium_video where userid ='$p' AND video_id =".$video->id."");
					foreach(@$users1 as $user1)
					{
					if($user1->end_date==$date)
					{
					$users2 = DB::select("update premium_video set video_type='' where userid='$p' AND video_id =".$video->id."");
					}
					}
					?>

					<?php if($video->type == 'embed'): ?>
						<div id="video_container" class="fitvid">
							<?= $video->embed_code ?>
						</div>
					<?php else: ?>
						<div id="video_container">
						<video id="video_player" class="video-js vjs-default-skin" controls preload="auto" poster="<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>" data-setup="{}" width="100%" style="width:100%;">
							<source src="<?= $video->mp4_url; ?>" type='video/mp4'>
							<source src="<?= $video->webm_url; ?>" type='video/webm'>
							<source src="<?= $video->ogg_url; ?>" type='video/ogg'>
							<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
						</video>
						</div>
					<?php  endif; ?>

			<?php else: ?>

				<div id="subscribers_only">
					<h2><?php if($video->access == 'subscriber'): ?>Sorry, this video is only available For Subscribed Users  <?php elseif($video->access == 'registered'): ?> Sorry, this video is only available For Registered Users <?php elseif($video->access == 'premium'): ?>This is Premium video and you need to purchase to watch<?php endif; ?></h2>
					<div class="clear"></div>
					<?php
					if(@ucwords(Auth::user()->username)== null)
					{
					?>
					<!--<form method="get" action="/subscription_plan">-->
						<a href="/subscription_plan" id="button"><?php if($video->access == 'subscriber'): ?><button id="button" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#<?php echo $video->id?>" style="background-color:#bfe527; padding: 25px 28px;"><b>Watch Trailer </b></button>&nbsp; &nbsp;&nbsp; &nbsp;<button id="button">Subscribe Now<?php elseif($video->access == 'registered'): ?><button id="button" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#<?php echo $video->id?>" style="background-color:#bfe527; padding: 25px 28px;"><b>Watch Trailer </b></button>&nbsp; &nbsp;&nbsp; &nbsp;<button id="button"> Register Here </button></a>
						<?php elseif($video->access == 'premium'): ?><a href="/subscription_plan?id=<?php echo $video->id; ?>" id="button"><button id="button" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#<?php echo $video->id?>" style="background-color:#bfe527; padding: 25px 28px;"><b>Watch Trailer </b></button>&nbsp; &nbsp;&nbsp; &nbsp; <button id="button">Purchase now ($<?php echo $video->price?>) <?php endif; ?></button></a>
					<!--</form>-->
					<?php
					}
					else
					{
					?>
					<!--<form method="get" action="<?php  //echo '/user/' . @ucwords(Auth::user()->username) . '/renew_subscription';?>">-->
						<a href="<?php  echo '/user/' . @ucwords(Auth::user()->username) . '/renew_subscription';?>" id="button"><?php if($video->access == 'subscriber'): ?><button id="button" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#<?php echo $video->id?>" style="background-color:#bfe527; padding: 25px 28px;"><b>Watch Trailor </b></button>&nbsp; &nbsp;&nbsp; &nbsp;<button id="button">Subscribe Now<?php elseif($video->access == 'registered'): ?>Login Here</button></a>
						<?php elseif($video->access == 'premium'): ?><a href="<?php  echo '/user/' . @ucwords(Auth::user()->username) . '/renew_subscription?id='.$video->id.'';?>" id="button"><button id="button" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#<?php echo $video->id?>" style="background-color:#bfe527; padding: 25px 28px;"><b>Watch Trailer </b></button>&nbsp; &nbsp;&nbsp; &nbsp;<button id="button">Purchase now ($<?php echo $video->price?>)<?php endif; ?></button></a>
					<!--</form>-->
					<?php
					}
					?>
				</div>

			<!--Start Video Trailor Modal-->
			<!-- Modal -->
<div id="<?php echo $video->id;?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $video->title;?> (Trailer)</h4>
      </div>
      <div class="modal-body">
	  <?php
       @$trailor = DB::select("select * from videos where id=".$video->id."");
					foreach ($trailor as $trailors)
					{
					if($trailors->trailor_embed_code==null)
					{
					echo "<h3>Trailer Video No Available</h3>";
					}
					else
					{
					?>
					<div id="video_container" class="fitvid">
					<?php echo $trailors->trailor_embed_code;?>
					</div>
					<?php
					}
					}
					?>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!--End Video Trailor Modal-->
			<?php endif; ?>
		</div>
	</div>


	<div class="video-details">

		<h3>
			<?= $video->title ?>
			<span class="view-count"><i class="fa fa-eye"></i> <?php if(isset($view_increment) && $view_increment == true ): ?><?= $video->views + 1 ?><?php else: ?><?= $video->views ?><?php endif; ?> Views </span>
			<div class="favorite btn btn-default <?php if(isset($favorited->id)): ?>active<?php endif; ?>" data-authenticated="<?= !Auth::guest() ?>" data-videoid="<?= $video->id ?>"><i class="fa fa-heart"></i> <span>Favorite</span></div>
			<div class="expand btn btn-default "><i class="fa fa-expand"></i> Full Mode</div>
		</h3>



		<div class="video-details-container"><?= $video->details ?></div>

		<div class="clear"></div>
		<h2 id="tags">Tags:
		<?php foreach($video->tags as $key => $tag): ?>

			<span><a href="/videos/tag/<?= $tag->name ?>"><?= $tag->name ?></a></span><?php if($key+1 != count($video->tags)): ?>,<?php endif; ?>

		<?php endforeach; ?>
		</h2>

		<div class="clear"></div>
		<div id="social_share">
	    	<p>Share This Video:</p>
			<?php include('partials/social-share.php'); ?>
		</div>

		<div class="clear"></div>

		<div id="comments">
			<div id="disqus_thread"></div>
		</div>

	</div>

</div>

<div class="col-md-2" id="right_sidebar">
<h6>Recent Videos</h6>
	<?php $videos = HelloVideo\Models\Video::where('active', '=', 1)->orderBy('created_at', 'DESC')->take(4)->get(); ?>
	<?php foreach($videos as $video): ?>
		<?php include('partials/video-block.php'); ?>
	<?php endforeach; ?>
</div>



	<script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = '<?= HelloVideo\Libraries\ThemeHelper::getThemeSetting(@$theme_settings->disqus_shortname, 'hellovideo') ?>';

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the comments</noscript>

	<script src="<?= THEME_URL . '/assets/js/jquery.fitvid.js'; ?>"></script>
	<script type="text/javascript">

		$(document).ready(function(){
			$('#video_container').fitVids();
			$('.favorite').click(function(){
				if($(this).data('authenticated')){
					$.post('/favorite', { video_id : $(this).data('videoid'), _token: '<?= csrf_token(); ?>' }, function(data){});
					$(this).toggleClass('active');
				} else {
					window.location = '/signup';
				}
			});

			$('.expand').click(function(){
					if($(this).hasClass('active')){
						$('#video_section').toggleClass('col-md-12').toggleClass('col-md-offset-2').toggleClass('col-md-8');
						$('#left-sidebar').show();
						$('#right_sidebar').show();
						$(this).removeClass('active');
						$('.menu-toggle').removeClass('right');
					} else {
						if($('#left-sidebar').css('display') == 'block'){
							$('#video_section').toggleClass('col-md-8').toggleClass('col-md-offset-2').toggleClass('col-md-12');
						} else {
							$('#video_section').toggleClass('col-md-10').toggleClass('col-md-12');
						}
						$(this).addClass('active');
						$('#left-sidebar').hide();
						$('.menu-toggle').addClass('right');
						$('#right_sidebar').hide();
					}
					$(window).trigger('resize');
			});

			$('.menu-toggle').click(function(){
				if($(this).hasClass('right') && $(window).width() > 991){
					$('#right_sidebar').show();
					$('#video_section').removeClass('col-md-12').addClass('col-md-10');
				}
				$(window).trigger('resize');
			});

		});

	</script>

	<!-- RESIZING FLUID VIDEO for VIDEO JS -->
	<script type="text/javascript">
	  // Once the video is ready
	  _V_("video_player").ready(function(){

	    var myPlayer = this;    // Store the video object
	    var aspectRatio = 9/16; // Make up an aspect ratio

	    function resizeVideoJS(){
	    	console.log(myPlayer.id);
	      // Get the parent element's actual width
	      var width = document.getElementById('video_container').offsetWidth;
	      // Set width to fill parent element, Set height
	      myPlayer.width(width).height( width * aspectRatio );
	    }

	    resizeVideoJS(); // Initialize the function
	    window.onresize = resizeVideoJS; // Call the function on resize
	  });
	</script>

	<script src="<?= THEME_URL . '/assets/js/rrssb.min.js'; ?>"></script>


<?php include('includes/footer.php'); ?>
