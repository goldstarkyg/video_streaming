
<div id="video_container">

<button class= "ad_counter" id="ad_counter" onclick="qwerty();" style="position: absolute; z-index: 2147483647; bottom: 56px; left: 39px; background: none repeat scroll 0% 0% rgba(16, 173, 60, 0.70); color: rgb(255, 255, 255); padding: 9px 20px; border:0px;">Skip Ads</button>
        <style>
		.video_link_placeholder {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    cursor: pointer;
    height: 95%;
    position: absolute;
    width: 100%;
    z-index: 999998;
    display: block !important;
}
		</style>
		<a href="<?php echo $video->ads_link;?>" target="_blank">
            <div id="video_link_placeholder"class="video_link_placeholder"></div></a>

						<video id="video_player2" oncontextmenu="return false;" class="video-js vjs-default-skin" autoplay controls preload="metadata" poster="<?= Config::get('site.uploads_url') . '/images/' . $video->image ?>" data-setup="{}" width="100%" style="width:100%;">
							<source src="<?= $video->ads; ?>" type='video/mp4'>
							<?php $subtitle=substr($video->subtitle,strrpos($video->subtitle, '/tmp/')+5);?>
						   <track label="English" kind="subtitles" srclang="en" src="/content/uploads/avatars/<?php echo $subtitle;?>" default>
                           <!--<track label="hindi" kind="subtitles" srclang="en" src="/content/uploads/avatars/<?php echo $video->subtitle;?>">-->

							<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
						</video>
						<script>
    $('#video_player2').click(function()
    {

        this.paused?this.play():this.pause();
    });
</script>
						</div>
<script type="text/javascript">
var nextVideo = "<?= $video->mp4_url; ?>";
var videoPlayer = document.getElementById('video_player2');
videoPlayer.addEventListener('ended', function(){
        videoPlayer.src = nextVideo;
		document.getElementById('ad_counter').style.visibility='hidden';
        }, false);

</script>
<script type="text/javascript">
    var nextVideo = "<?= $video->mp4_url; ?>";
    var videoPlayer = document.getElementById('video_player2');
     function qwerty(){
	     document.getElementById('ad_counter').style.visibility='hidden';
         document.getElementById("video_link_placeholder").classList.remove("video_link_placeholder");
        videoPlayer.src = nextVideo;
}
</script>
