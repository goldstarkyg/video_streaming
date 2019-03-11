
<?php include('includes/header.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<?php
  @$video_id = $video->id;
  @$user_id = Auth::user()->id;
  @$favorite =DB::select("select * from favorites where video_id='".$video->id."' and user_id='".$user_id."'");
  if(!empty($favorite)) $favorited = $favorite[0];
?>
<script>
	$(document).ready(function(){
		//console.log($('meta[name="_token"]').attr('content'));
		$.ajax({
			type: "POST",
			url: '/updatecurrentvideoview',
			data: {'data':<?php echo $video;?>, '_token':$('meta[name="_token"]').attr('content')},
			success: function(response){
				console.log(response);
			},
		});

		$('.favorite').click(function(){
			if($(this).data('authenticated')){
				$.post('/favorite',
					{ video_id : $(this).data('videoid'),
						_token: '<?= csrf_token(); ?>' },
					function(data){

					});
				$(this).toggleClass('active');
			} else {
				window.location = '/signup';
			}
		});

		$("#skip").click(function(){			
			$("#ads_container").css('display', 'none');
			$("#video_container").css('display', 'block');
		});
		<?php
		if(is_null($ad)){
		?>
		$("#ads_container").css('display', 'none');
		$("#video_container").css('display', 'block');
        <?php  } ?>

	});
</script>
<style>
    video::-webkit-media-controls-fullscreen-button {
        margin-right: -32px;
        z-index: 10;
        position: relative;
        background: #fafafa;
        background-image: url(https://image.flaticon.com/icons/svg/151/151926.svg);
        background-size: 50%;
        background-position: 50% 50%;
        background-repeat: no-repeat;
    }

</style>

<?php
$domain =  'http://'.$_SERVER['SERVER_NAME']."/" ;
$url=$_SERVER['REQUEST_URI'];

//$url="video/Brainy%20Animations%20-%20Taking%20Care%20of%20Your%20Plants";
$title=substr($url,strrpos($url, 'video/')+6);
@$title;
  $a=$string = str_replace('-',' ', $title);


  function editEmbed($e)
  {

    if(! is_null($e) && ($e != strip_tags($e)) ){

      $e = str_replace('"' , "'" , $e);
      $pos = strpos($e , "'" , strpos($e , 'youtube'));

      return substr_replace($e , '&autoPlay=1&enablejsapi=1' , $pos , 0);
    }

    return $e;
  }
?>

<?php

@$p=Auth::user()->email;
if(@$p==null AND $video->access == 'registered')
{

	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
$('#mylogin').modal('show');
});
</script>
	<?php
}
?>

<?php

@$p=Auth::user()->email;
if(@$p==null AND $video->access == 'subscriber')
{

	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
$('#mylogin').modal('show');
});
</script>
	<?php
}
?>

	<?php
		@$p=Auth::user()->email;
		if(@$p==null AND $video->access == 'premium'){
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#mylogin').modal('show');
		});
	</script>
	<?php
		}
	?>
<div class="col-md-8 col-md-offset-2 right-content-8" id="video_section" style="padding:0px;">
	<div id="video_title">
		<div class="container-fluid">
			<span class="label">You're watching:</span> <h1><?= $video->title ?></h1>
		</div>
	</div>
	<div id="video_bg" style="background-image:url(<?= Config::get('site.uploads_url') . '/images/' . str_replace(' ', '%20', $video->image) ?>)">
		<div class="container-fluid">
			<?php
               @$p4=Auth::user()->id;
				@$p3=Auth::user()->user_id;
				$p1=DB::select("select * from assignto where video_id='".$video->id."'");
				$id1="";
				$user1="";
				foreach($p1 as $p2){
				if($user1==""){
					$user1=$p2->user_id;
				}else{
					$user1=$p2->user_id;
				}
				if($id1==""){
					$id1=$p2->video_id;
				}else{
					$id1=$p2->video_id;
				}
			}
			?>
			<?php
			    @$p=Auth::user()->email;
			    if(@$p!=null){
			        $or1="||";
				    $con= @Auth::user()->user_id."==".@$user1 ."||". @Auth::user()->id."==".@$user1;
			    }
			?>
            <?php
				@$p;
                $date=date('Y-m-d');
                @$enddate=@Auth::user()->end_plan;

				if($enddate==$date){
					@$users10 = DB::select("update users set role='registered' where email ='$p'");
				}
				@$users = DB::select("select * from premium_video where userid ='$p' AND video_id =".$video->id."");
//			    @$users = DB::select("select * from premium_video where  video_id =".$video->id."");
				$id="";
				$video_type="";
				foreach ($users as $user){
					$user->video_id;
					if($id==""){
					    $id=$user->video_id;
					}else{
					    $id=$user->video_id;
					}
					if($video_type==""){
					    $video_type=$user->video_type;
					}else{
					   $video_type=$user->video_type;
					}
				}

			?>

			<?php if( Auth::check() == 0){
					 //start** if video access is guest
               		 if( $video->access == 'guest' ){
							$date=date('Y-m-d');
							@$p=Auth::user()->email;
							@$p;
							@$users1 = DB::select("select * from premium_video where userid ='$p' AND video_id =".$video->id."");
							foreach(@$users1 as $user1){
								if($user1->end_date==$date){
									$users2 = DB::select("update premium_video set video_type='' where userid='$p' AND video_id =".$video->id."");
								}
							}

							if($video->type == 'embed'){
								if(! is_null($ad)){
			?>
								<div id="ads_container">
									<div id="ads_player" class="fitvid">
										<script>
											window._wq = window._wq || [];
											_wq.push({
												id: "<?=$ad->link?>",
												options: {
													videoFoam: true,
													autoPlay: true,
													playerColor: "ff0000",
													plugin: {}
												}
											});
										</script>
										<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js"
												async></script>
										<div class="wistia_embed wistia_async_<?= $ad->link ?>"
											 style="width:640px;height:360px;">&nbsp;</div>
									</div>
									<h3  style="position: absolute; z-index: 2147483647; top: 10px; left: 50px; color: rgb(255, 255, 255);border:0px;"><i class="fa fa-external-link" aria-hidden="true"></i> &nbsp; &nbsp;<?=$ad->title?></h3>
									<button class= "ad_counter" style="position: absolute; z-index: 2147483647; bottom: 56px; left: 39px; background: none repeat scroll 0% 0% rgba(246, 103, 35, 0.20); color: rgb(255, 255, 255); padding: 9px 20px; border:0px;">Ad : <?=$ad->time?> :<a href='<?=$ad->ads_link?>' target='_blank'> <?=$ad->ads_link?> </a>  </button>
									<button id= "skip" style="display:block;position: absolute; z-index: 2147483647; bottom: 56px; right: 39px; background: none repeat scroll 0% 0% rgba(102, 102, 102, 0.50); color: rgb(255, 255, 255); padding: 9px 20px; border:0px;"> Skip <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
									<style>
										.video_link_placeholder {
																background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
																cursor: pointer;
																height: 70%;
																position: absolute;
																width: 100%;
																z-index: 999998;
																display: block !important;
															}
									</style>
									<a href="<?php echo $ad->ads_link;?>" target="_blank"><div class="video_link_placeholder"></div></a>
								</div>
								<?php
								}
								?>
								<div id="video_container" class="fitvid" style="display: none">
									<?php if($video->type1!=0 OR $video->live=="live")
									{
										if($video->video_type == "wistia") {
											?>
											<script>
												window._wq = window._wq || [];
												_wq.push({
													id: "<?=$video->embed_code?>",
													options: {
														videoFoam: true,
														autoPlay: true,
														playerColor: "ff0000",
														plugin: {}
													}
												});
											</script>
											<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js"
													async></script>
											<div class="wistia_embed wistia_async_<?= $video->embed_code ?>"
												 style="width:640px;height:360px;">&nbsp;</div>
											<?php
										}else {
											?>
											<div><?= $video->embed_code ?></div>
									<?php
										}
									}
									?>
								</div>
            				<?php }else{
									if(! is_null($ad)){
								?>
										<div id="video_container">
											<video id="video_player1" oncontextmenu="return false;" class="video-js vjs-default-skin" autoPlay controls preload="auto" poster="<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>" data-setup="{}" width="100%" style="width:100%;">
												<source src="<?= $video->mp4_url; ?>" type='video/mp4'>
												<?php $subtitle=substr($video->subtitle,strrpos($video->subtitle, '/tmp/')+5);?>
											   <track label="English" kind="subtitles" srclang="en" src="/content/uploads/avatars/<?php echo $subtitle;?>" default>
											   <!--<track label="hindi" kind="subtitles" srclang="en" src="/content/uploads/avatars/<?php echo $video->subtitle;?>">-->

												<source src="<?= $video->webm_url; ?>" type='video/webm'>
												<source src="<?= $video->ogg_url; ?>" type='video/ogg'>
												<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
											</video>
										</div>
										<script>
											$('#video_player1').click(function(){
												this.paused?this.play():this.pause();
											});
									   </script>
										<?php }else{
											include('awsads.php');
										}
							 }
					   }
					  //end**  if video access is guest
			 	}
            ?>

            <?php

				if( Auth::check() &&
					($video->access == 'registered' && @Auth::check() == 1) ||
				//($video->access == 'registered' && @Auth::user()->role == 'subscriber') ||
				($video->access == 'subscriber' && @Auth::user()->role == 'subscriber') ||
				(@Auth::user()->adm == 'admin')  ||
				(@Auth::user()->id == $video->user_id) ||
				(@Auth::user()->user_id==$user1 AND $video->id==$id1) ||
				(@Auth::user()->id==$user1 AND $video->id==$id1)
				)  {

				 	if($video->type == 'embed'){ //start** if type is embed
		    		    if(! is_null($ad)){
			?>    		  <div id="ads_container">
							<div id="ads_player" class="fitvid">
										<script>
											window._wq = window._wq || [];
											_wq.push({
												id: "<?=$ad->link?>",
												options: {
													videoFoam: true,
													autoPlay: true,
													playerColor: "ff0000",
													plugin: {}
												}
											});
										</script>
										<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js"
												async></script>
										<div class="wistia_embed wistia_async_<?= $ad->link ?>"
											 style="width:640px;height:360px;">&nbsp;</div>
							</div>
							<h3  style="position: absolute; z-index: 2147483647; top: 10px; left: 50px; color: rgb(255, 255, 255);border:0px;"><i class="fa fa-external-link" aria-hidden="true"></i> &nbsp; &nbsp;<?=$ad->title?></h3>
							<button class= "ad_counter" style="position: absolute; z-index: 2147483647; bottom: 56px; left: 39px; background: none repeat scroll 0% 0% rgba(246, 103, 35, 0.20); color: rgb(255, 255, 255); padding: 9px 20px; border:0px;">Ad : <?=$ad->time?> :<a href='<?=$ad->ads_link?>' target='_blank'> <?=$ad->ads_link?> </a>  </button>
							<button id= "skip" style="display:block;position: absolute; z-index: 2147483647; bottom: 56px; right: 39px; background: none repeat scroll 0% 0% rgba(102, 102, 102, 0.50); color: rgb(255, 255, 255); padding: 9px 20px; border:0px;"> Skip <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
							<style>
								.video_link_placeholder {
															background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
															cursor: pointer;
															height: 70%;
															position: absolute;
															width: 100%;
															z-index: 21474836479;
															display: block !important;
														}
							</style>
							<a href="<?php echo $ad->ads_link;?>" target="_blank"><div class="video_link_placeholder"></div></a>
						  </div>
						<?php
						}

						?>
						
						<div id="video_container" class="fitvid" style="display: none">
							<?php if($video->type1!=0 OR $video->live=="live")
							{
								if($video->video_type == 'wistia') {
									?>
									<script>
										window._wq = window._wq || [];
										_wq.push({
											id: "<?=$video->embed_code?>",
											options: {
												videoFoam: true,
												autoPlay: true,
												playerColor: "ff0000",
												plugin: {}
											}
										});
									</script>
									<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js"
											async></script>
									<div class="wistia_embed wistia_async_<?= $video->embed_code ?>"
										 style="width:640px;height:360px;">&nbsp;</div>
									<?php
								}else { ?>
									<div><?= $video->embed_code ?></div>
									<?php
								}
							}
							?>
						</div>
				<?php }
			 //end** if type is embed ?>

        <?php } else if( Auth::check() && $video->access == 'premium' &&  $video_type == 'premium' ||
        			@Auth::user()->adm == 'admin' || @Auth::user()->id == $video->user_id ) {

					/*($video->access == 'premium' && @$video_type && (@$video->id == @$id) ) ||
					@Auth::user()->adm == 'admin' ||
					@Auth::user()->id == $video->user_id*/				
		?>

			<?php if($video->type == 'embed'){
					if(!is_null($ad)){
		?>
					<div id="ads_container">
							<div id="ads_player" class="fitvid">
								<script>
									window._wq = window._wq || [];
									_wq.push({
										id: "<?=$ad->link?>",
										options: {
											videoFoam: true,
											autoPlay: true,
											playerColor: "ff0000",
											plugin: {}
										}
									});
								</script>
								<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js"
										async></script>
								<div class="wistia_embed wistia_async_<?= $ad->link ?>"
									 style="width:640px;height:360px;">&nbsp;</div>
							</div>
							<h3  style="position: absolute; z-index: 2147483647; top: 10px; left: 50px; color: rgb(255, 255, 255);border:0px;"><i class="fa fa-external-link" aria-hidden="true"></i> &nbsp; &nbsp;<?=$ad->title?></h3>
							<button class= "ad_counter" style="position: absolute; z-index: 2147483647; bottom: 56px; left: 39px; background: none repeat scroll 0% 0% rgba(246, 103, 35, 0.20); color: rgb(255, 255, 255); padding: 9px 20px; border:0px;">Ad : <?=$ad->time?> :<a href='<?=$ad->ads_link?>' target='_blank'> <?=$ad->ads_link?> </a>  </button>
							<button id= "skip" style="display:block;position: absolute; z-index: 2147483647; bottom: 56px; right: 39px; background: none repeat scroll 0% 0% rgba(102, 102, 102, 0.50); color: rgb(255, 255, 255); padding: 9px 20px; border:0px;"> Skip <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
							<style>
								.video_link_placeholder {
									background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
									cursor: pointer;
									height: 70%;
									position: absolute;
									width: 100%;
									z-index: 999998;
									display: block !important;
								}
							</style>
							<a href="<?php echo $ad->ads_link;?>" target="_blank"><div class="video_link_placeholder"></div></a>
						</div>
					<?php
					}
					?>
					<div id="video_container" class="fitvid" style="display: none">
						<?php if($video->type1!=0 OR $video->live=="live")
						{
							if($video->video_type == 'wistia') {
								?>
								<script>
									window._wq = window._wq || [];
									_wq.push({
										id: "<?=$video->embed_code?>",
										options: {
											videoFoam: true,
											autoPlay: true,
											playerColor: "ff0000",
											plugin: {}
										}
									});
								</script>
								<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js"
										async></script>
								<div class="wistia_embed wistia_async_<?= $video->embed_code ?>"
									 style="width:640px;height:360px;">&nbsp;</div>
								<?php
							}else {
								?>
								<div ><?= $video->embed_code ?></div>
						<?php
							}
						}
						?>
					</div>
			<?php  } ?>
			<?php } else { ?>
				<div id="subscribers_only">
				<?php if( Auth::check()){ ?>
				<h2><?php if($video->access == 'subscriber'): ?>Sorry, this video is only available For Subscribed Users
								<?php elseif($video->access == 'registered'): ?>
										Sorry, this video is only available For Registered Users
								<?php elseif($video->access == 'premium'): ?>
										This is <?php if($video->live=="live"){ echo "Live video";
													}else{
												?> Premium video
												<?php } ?>
									and you need to purchase to watch
					<?php endif; } ?>
				</h2>
				<div class="clear"></div>
				<?php

					if(@ucwords(Auth::user()->email)== null){
				?>
					<?php if($video->access == 'subscriber'){ ?>
<!--						<button id="button" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mymodal1" style="background-color:#bfe527; padding: 25px 28px;">-->
<!--							<b>Watch Trailer </b>-->
<!--						</button>&nbsp; &nbsp;&nbsp; &nbsp;-->
						<span class="login-desktop">
							<a href="" data-toggle="modal" data-target="#mylogin" id="button">
								<button id="button">Subscribe Now
					<?php } else if($video->access == 'registered') { ?>
							</a>
						</span>
						<span class="login-desktop">
							<a href="" data-toggle="modal" data-target="#mylogin">
								<button id="button"> Register Here </button>
							</a>
						</span>
					<?php } else if($video->access == 'premium') { ?>
						<button id="button" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mymodal1" style="background-color:#bfe527; padding: 25px 28px;">
							<b>Watch Trailer </b></button>&nbsp; &nbsp;&nbsp; &nbsp;
							<span class="login-desktop">
								<a href="" data-toggle="modal" data-target="#mylogin" id="button">
									<button id="button">Purchase now ($<?php echo $video->price?>)

					<?php } ?>
								</button>
								</a>
						</span>
				<?php }else{ ?>
				  
					<?php if($video->access == 'subscriber'){ ?>
<!--						<button id="button" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mymodal1" style="background-color:#bfe527; padding: 25px 28px;">-->
<!--							<b>Watch Trailer </b>-->
<!--						</button>&nbsp; &nbsp;&nbsp; &nbsp;-->
						<button id="button" data-toggle="modal" data-target="#myModal1">Subscribe Now
					<?php }else if($video->access == 'registered') { ?>
						Login Here</button>
					<?php } else if($video->access == 'premium'){ ?>
						<button id="button" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mymodal1" style="background-color:#bfe527; padding: 25px 28px;">
							<b>Watch Trailer </b>
						</button>&nbsp; &nbsp;&nbsp; &nbsp;
						<button id="button" data-toggle="modal" data-target="#myplan">Purchase now ($<?php echo $video->price?>)
					<?php } ?></button>
						<div id="myplan" class="modal fade" role="dialog">
							<div class="modal-dialog paypal-modal-dialog" style="">
							<!-- Modal content-->
								<div class="modal-content">
								  <div class="modal-header" style="background-color: #797b74; padding:6px;">
									<button type="button" class="close" data-dismiss="modal" style="padding: 2px 6px; border-radius:0px">&times;</button>
									<h4 class="modal-title" style="text-align: left; padding-top: 0px;  color:#fff;">Please Make Payment </h4>
								  </div>
								  <div class="modal-body paypal-modal-body">
									<?php include('premiumplan.php');?>
									<br>
									<br>
								  <a href="<?php echo $domain ?>"><button type="button" class="btn btn-info btn-lg" style="padding: 8px 15px; margin-top: 24px; background-color:#27cc95">Continue As Free User</button></a>
								  </div>
								</div>
							</div>
						</div>
				<?php } ?>

				<!-- Modal -->
				<div id="myModal1" class="modal fade" role="dialog">
					<div class="modal-dialog paypal-modal-dialog" style="">
					<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header" style="background-color: #797b74; padding:6px;">
							<button type="button" class="close" data-dismiss="modal" style="padding: 2px 6px; border-radius:0px">&times;</button>
							<h4 class="modal-title" style="text-align: left; padding-top: 0px;  color:#fff;">Select a Plan</h4>
						  </div>
						  <div class="modal-body paypal-modal-body">
							<?php include('subplan.php');?>
							<br>
							<br>
						  <a href="<?php echo $domain ?>"><button type="button" class="btn btn-info btn-lg" style="padding: 8px 15px; margin-top: 24px; background-color:#27cc95">Continue As Free User</button></a>
						  </div>
						  <!-- <div class="modal-footer">
						  </div> -->
						</div>
					</div>
				</div>
			</div>
			<!--Start Video Trailor Modal-->
			<!-- Modal -->
			<div id="mymodal1" class="modal fade" role="dialog">
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
									foreach ($trailor as $trailors){
										if($trailors->trailor_embed_code==null){
											echo "<h3>Video Trailer Not Available</h3>";
										}else{
								?>
								<?php //echo $trailors->trailor_embed_code;?>
											<div id="trailer_container" class="fitvid">
													<script>
														window._wq = window._wq || [];
														_wq.push({
															id: "<?=$trailors->trailor_embed_code?>",
															options: {
																videoFoam: true,
																autoPlay:true,
																playerColor: "ff0000",
																plugin: {

																}
															}
														});
													</script>
													<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js" async></script>
													<div class="wistia_embed wistia_async_<?=$trailors->trailor_embed_code?>" style="width:640px;height:360px;">&nbsp;</div>
											</div>
								<?php }
									} ?>
							</div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
					</div>
				</div>
			</div>
			<script>
				$('#mymodal').on('hidden.bs.modal', function () {
				   $('#mymodal .modal-body').empty();
				});
				$('#mymodal').on('show.bs.modal', function (e) {
					var idVideo = $(e.relatedTarget).data('id');
					$('#mymodal .modal-body').html('<?php if($trailors->trailor_embed_code==null){ echo "<h3>Video Trailer Not Available</h3>"; } else { echo $trailors->trailor_embed_code;}?>');
				});
			</script>
			<!--End Video Trailor Modal-->
			<?php } ?>
		</div>
	</div>
	<div class="video-details">
		<h3>
			<?= $video->title ?>
			<?php
				@$p4=Auth::user()->email;
			    if(@$p4==null){
			?>
				<div class="" style="float:right;"><i class="fa fa-heart" data-toggle="modal" data-target="#mylogin"></i>
					<span data-toggle="modal" data-target="#mylogin">Favorite</span>
				</div>
			<?php }else{ ?>
				<div class="favorite btn btn-default
						<?php if(isset($favorited->id)){ ?>active<?php } ?>" data-authenticated="<?= !Auth::guest() ?>"
					 data-videoid="<?= $video->id ?>">
					<i class="fa fa-heart"></i>
					<span>Favorite</span>
				</div>
			<?php
			}
			?>
<!--			<div class="expand btn btn-default ">-->
<!--				<i class="fa fa-expand"></i> Full Mode-->
<!--			</div>-->
		</h3>
        <?php
		   if($video->live!="live"){
		?>
		<div class="video-details-container"><?= $video->details ?></div>
		<div class="clear"></div>
		<h2 id="tags" style="color: #999;" >Uploaded By:
			<?php
				$users1=DB::select("select * from users where id='$video->user_id'");
				foreach($users1 as $user){
			?>
			<span style="color: #999;"><?= @$user->username ?></span>
			<?php } ?>
        </h2>

		<h2 id="tags">Tags:
		<?php
		//$videos4=DB::select("select * from ");
		//foreach($video->tags as $key => $tag): ?>

			<!--<span><a href="/videos/tag/<?= @$tag->name ?>"><?= @$tag->name ?></a></span><?php if(@$key+1 != count(@$video->tags)): ?>,<?php endif; ?>-->

		<?php //endforeach; ?>
		</h2>
		<div class="clear"></div>
		<div id="social_share">
	    	<p>Share This Video:</p>
			<?php include('partials/social-share.php'); ?>
		</div>
		<div class="clear"></div>
		<div id="comments" id="app">
			<?= $comments; ?>
		</div>
        <?php } ?>
	</div>
</div>

	<div class="col-md-2" id="Elchat" >
	<?php
		@$roll=Auth::user()->role;
		if($video->live=="live" and @$p!=null AND @$roll=="subscriber" and $video->video_type == 'live' OR (@$roll=="admin" AND $video->live=="live" and $video->video_type == 'live')){
	?>
	<!-- bootstrap -->
<!--		<link rel="stylesheet" href="--><?//= THEME_URL . '/assets/css/bootstrap.min.css';?><!--">-->
		<link rel="stylesheet" href="<?= THEME_URL . '/assets/livechatcss/prism.css'; ?>">
		<script src="<?= THEME_URL . '/assets/livechatjs/jquery.min.js'; ?>"></script>
		<script src="<?= THEME_URL . '/assets/livechatjs/prism.js'; ?>"></script>
		<script src="<?= THEME_URL . '/assets/livechatjs/chatSocketAchex.js'; ?>"></script>
		<link rel="stylesheet" type="text/css" href="<?= THEME_URL . '/assets/livechatcss/chatSocketAchex.css'; ?>">
	<!-- Modal -->
		<div id="i">
			<script type="text/javascript">
				$('#Elchat').ChatSocket({
					'lblEntradaNombre':'<?php echo @$p=Auth::user()->username;?>'
				});
			</script>
		</div>
		<script type="text/javascript">
			document.getElementById("ElchatlistaOnline").remove();
			document.getElementById("txtEntrar").value = "<?php echo @$p=Auth::user()->username;?>";
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
				$('#happy123').click(function(){
					alert("wana close ?");
					//$('#smallModal').modal('hide');
				});
			});
		</script>
		<?php }else{ ?>
		<h6 style="color:#fff;">Recent Videos</h6>
		<?php
			$videos = DB::select("select * from videos where access='$video->access' AND active=1 order by id desc limit 4") ;
			foreach($videos as $video){
				include('partials/sidevideos.php');
			}
		?>
		<?php } ?>
	</div>


    </script>
	<script src="<?= THEME_URL . '/assets/js/jquery.fitvid.js'; ?>"></script>

  <?php if(Auth::check()) {?>

	  <?php if(Auth::user()->role != 'admin') {?>
		  <script>
			  $(document).ready(function(){

				 $('.delete').hide();
			  });
		  </script>
	  <?php }
  }?>
	<script type="text/javascript">

		$(document).ready(function(){

			$('.video_link_placeholder').click(function(){
				document.getElementsByTagName('iframe')[0].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
			  });
       		$('.edit').hide();
			$('#video_container').fitVids();

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
	  $("#video_player1").ready(function(){

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jplayer/2.9.2/add-on/jplayer.playlist.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jplayer/2.9.2/jplayer/jquery.jplayer.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jplayer/2.9.2/skin/blue.monday/css/jplayer.blue.monday.min.css" rel="stylesheet" />
<script src="/application/public/vendor/comments/js/comments-react.js"></script>
	<script src="<?= THEME_URL . '/assets/js/rrssb.min.js'; ?>"></script>
<script>
function abc() {
	$("#messages1").animate({
  scrollTop: $('#messages1')[0].scrollHeight
}, 1000);
}
function aaa(event) {
	var x = event.which || event.keyCode;
	if(x == 13)
{
    $("#messages1").animate({
  scrollTop: $('#messages1')[0].scrollHeight
}, 1000);
}
}
</script>

<?php include('includes/footer.php'); ?>
