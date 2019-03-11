<?php include('includes/header.php'); ?>
<script>
$(document).ready(function(){
    $("input[type=file]").change(function(){
	 var filename = $(this).val().replace(/^.*\\/, "");
        //alert(filename);
		 document.getElementById("fileid").value = filename;
    });
	
});
		</script>
<div class="col-md-10 col-md-offset-2 right-content-10 user">
	<?php
$videos = DB::select("select * from videos where id='".$_GET['id']."'");
						
			foreach($videos as $video)
			{
			?>
		<h4 class="subheadline" style="color:#fff;"><i class="fa fa-edit" style="color:#fff;"></i> <?php echo $video->title;?></h4>
		<div class="clear"></div>

		 <form action="http://aflix-storage.storage.googleapis.com" method="post" enctype="multipart/form-data">
            <div id="awsserver" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update Video Google Cloud</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="success_action_redirect" value="<?php echo 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];'' ?>">
	  <input type="hidden" id="fileid" name="key"  class="form-control">
	  <br>
        <input type="file" multiple="true" class="form-control" name="file" id="buttonid" />
                            <br>
                            <input type="submit" value="Update Video" class="btn btn-success pull-right" />
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
		
		<form method="POST" action="edit_video_user" id="" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

			<input type="hidden" value="<?php echo $video->id;?>" name="edit_id">

			<div class="well">
				<?php if($errors->first('username')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('username'); ?></div><?php endif; ?>
				<label for="username">Title</label>
				<script type="text/javascript">
    function blockSpecialChar(e){
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
        }
    </script>
				<input type="text" class="form-control" name="title" id="title" onkeypress="return blockSpecialChar(event)" value="<?php echo $video->title;?>" />
			</div>

			<div class="well">
				<?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
				<label for="email">Video Image Cover Min-(Width:1200px And Height:500px)</label>
				<img src="<? {{ echo Config::get('site.uploads_dir') . 'images/' . $video->image; }}?>" class="video-img" width="200"/>
				<br>
				<input type="file" multiple="true" class="form-control" name="file" id="file"  />
				<input type="hidden" value=<?php echo $video->image; ?> class="form-control" name="file" id="file"  />
			</div>
            <script src="//fast.wistia.com/assets/external/api.js" async></script>
<link rel="stylesheet" href="//fast.wistia.com/assets/external/uploader.css" />
			 <div class="col-md-12">
                <div class="col-md-6">
			
				<label for="password">Update Wistia Video</label>
				<script src="//fast.wistia.com/assets/external/api.js" async></script>
					<link rel="stylesheet" href="//fast.wistia.com/assets/external/uploader.css" />
					<div id="wistia_upload_button_button_only" alt="Upload Video"></div>
					<script>
                        window._wapiq = window._wapiq || [];
                        _wapiq.push(function(W) {

                            window.wistiaUploader = new W.Uploader({
                                accessToken: "b7fe5a536e6f402ec24cc7ec537f7b3741200cfdfc212c1fe1538c1516a21eea",
                                button: "wistia_upload_button_button_only",
                                projectId: "kg2oj1plzb",
                                embedCodeOptions: {
                                    playerColor: "56be8e",
                                    embedType: "iframe"
                                }
                            });
                            wistiaUploader.bind("uploadembeddable", function(file, media, embedCode, oembedResponse) {
                                //alert(embedCode);

                                //var sa = oSelectBox.options[iChoice].text;
                                document.getElementById("a").value = embedCode;
// save the embed code to your database to display the video in the future
                            });
                        });

					</script>
			</div>
			 <div class="col-md-6">
                    <label for="password">Update on AWS Video</label>
                <a href="" data-toggle="modal" data-target="#awsserver">
                   <button style="background-color: #f7f6f4;
    border: 1px solid #bbb;
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    color: #888;
    cursor: pointer;
    display: inline-block;
    font-family: WistiaPlayerOverpass,Helvetica,Arial;
    font-size: 14px;
    height: 34px;
    line-height: 34px;
    margin: 0;
    overflow: hidden;
    padding: 0;
    position: relative;
    text-align: center;
    vertical-align: top;
    width: 120px;
    zoom: 1;">Upload Video</button>
                </a>
                </div>
			</div>
			<?php
            if(@$_GET['bucket']==null)
            {
                ?>
			<div class="well">
				<label for="password">Video Source</label>
				<input type="hidden" id="type" name="embed" value="embed" />
				<textarea class="form-control" placeholder="Embed Code"   name="embed_code" id="a"/><?php echo $video->embed_code;?></textarea>
			</div>
			<?php
            }
            else
            {
                ?>
                <div class="well">
                    <label for="password">Video Source</label>
                    <input type="hidden" id="type" name="embed" value="mp4_url" />
                    <textarea class="form-control" name="mp4_url" ><?php echo 'https://storage.googleapis.com/aflix-storage/'.$_GET["key"].'"';?></textarea>
                </div>
                <?php
            }
            ?>
			<?php
			
			if($video->mp4_url!=null AND @$_GET['bucket']==null)
			{
			?>
			 <input type="hidden" id="type" name="embed" value="mp4_url" />
			<input type="hidden" name="mp4_url" value="<?php echo $video->mp4_url;?>">
			<?php
			}
			?>
			
			<div class="well">
				<label for="password">Video Details, Links, and Info</label>
				<textarea class="form-control" placeholder="" name="full" id="full" ><?php echo $video->details;?></textarea>
			</div>
            <div class="well">
				<label for="password">Short Description</label>
				<textarea class="form-control" placeholder="" name="short" id="short" ><?php echo $video->description;?></textarea>
			</div>
			
			 <div class="well">
				<label for="password">Category</label>
				<select name="category" id="category" value="" >
				<?php
				@$users = DB::select("select * from video_categories");
					foreach ($users as $user) 
					{
					?>
					<option value="<?php echo $user->id;?> <?php if($user->id==$video->video_category_id) { echo "Selected";} ?>"><?php echo $user->name;?></option>
					<?php
					}
					?>
				</select>
			</div>
			 <div class="well">
				<label for="password">User Access</label>
			<select id="access" name="access" onchange="myFunction()">
								<option value="guest" <?php if($video->access=="guest") { echo "Selected";} ?>>Guest (everyone)</option>
								<option value="registered" <?php if($video->access=="registered") { echo "Selected";} ?>>Registered Users (free registration must be enabled)</option>
								<option value="subscriber" <?php if($video->access=="subscriber") { echo "Selected";} ?>>Subscriber (only paid subscription users)</option>
								<option value="premium" <?php if($video->access=="premium") { echo "Selected";} ?>>Premium (Premium Video )</option>
							</select>
			</div>
			<div class="well">
			<div class="panel-body" id="hello"> 
							<p>Enter Price </p> 
							<input class="form-control" value="<?php echo $video->price;?>" name="price" id="price"  >
						</div>
						<div class="panel-body" id="hello1"> 
							<p>Enter Validity</p> 
							<input class="form-control" name="validate1" value="<?php echo $video->validate1;?>" id="validate1" >
							<br>
							<p>Enter Video Trailor</p> 
						<textarea class="form-control" name="trailor_embed_code"  id="trailor_embed_code"><?php echo $video->trailor_embed_code;?></textarea>
						
						</div> 
						<div class="panel-body" id="hello2"> 
							<p>Enter Video Trailor</p> 
						<textarea class="form-control" name="trailor_embed_code"  id="trailor_embed_code"><?php echo $video->trailor_embed_code;?></textarea>
						
						</div>
						</div>
						
			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="Edit  Video" class="btn btn-primary" />
<script type="text/javascript">
               $(document).ready(function(){

               	                  $("#hello").hide();
                                  $("#hello1").hide();
								  $("#hello2").hide();
                                   });
						function myFunction() {
						var e = document.getElementById("access");
                        var a = e.options[e.selectedIndex].value;
                              if(a=='premium')
                              	{ 
                                  $("#hello").show();
                                  $("#hello1").show();
								   $("#hello2").show();
                              	}
								else
                              	{
                              		$("#hello").hide();
                                  $("#hello1").hide();
								   $("#hello2").hide();
                              	}
								if(a=='subscriber')
                              	{ 
                                  $("#hello2").show();
                                 
                              	}
								else
                              	{
                              		$("#hello2").hide();
                                  
                              	}
                              	
                              }
                        
						</script>
			<div class="clear"></div>
		</form>

	
</div>
<?php
}
?>
<?php include('includes/footer.php'); ?>