<?php include('includes/header.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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

        <h4 class="subheadline" style="color:#fff;"><i class="fa fa-edit" style="color:#fff;"></i>Add New Video</h4>
        <div class="clear"></div>

         <form action="http://aflix-storage.storage.googleapis.com" method="post" enctype="multipart/form-data">
            <div id="awsserver" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Upload Video Google Cloud</h4>
                        </div>
                        <div class="modal-body">
                           <input type="hidden" name="success_action_redirect" value="<?php echo 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];'' ?>">
	  <input type="hidden" id="fileid" name="key"  class="form-control">
	  <br>
        <input type="file" multiple="true" class="form-control" name="file" id="buttonid" />
                            <input type="submit" value="Upload Video" class="btn btn-success pull-right" />
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form method="POST" action="create_video_user" id="" accept-charset="UTF-8" file="1" enctype="multipart/form-data">
		
		 <script src="//fast.wistia.com/assets/external/api.js" async></script>
            <link rel="stylesheet" href="//fast.wistia.com/assets/external/uploader.css" />
            <div class="col-md-12">
			<label for="password" style="color:#000; border-bottom:solid 1px #ccc; padding:10px;">Upload Video Here</label>
                <div class="col-md-6">
                <label for="password">Upload on Wista</label>
                <script src="//fast.wistia.com/assets/external/api.js" async></script>
                <link rel="stylesheet" href="//fast.wistia.com/assets/external/uploader.css" />
                <div id="wistia_upload_button_button_only" alt="Upload Video"></div>
                <script>
                    window._wapiq = window._wapiq || [];
                    _wapiq.push(function(W) {

                        window.wistiaUploader = new W.Uploader({
                            accessToken: "604c337996df0f0a2da8177db5f65c1f4e72dea6",
                            button: "wistia_upload_button_button_only",
                            projectId: "d1377ab7t1",
                            embedCodeOptions: {
                                playerColor: "56be8e",
                                embedType: "iframe"
                            }
                        });
                        wistiaUploader.bind("uploadembeddable", function(file, media, embedCode, oembedResponse) {
                            //alert(media.id);

                            //var sa = oSelectBox.options[iChoice].text;
                            document.getElementById("a").value = media.id;
// save the embed code to your database to display the video in the future
                        });
                    });

                </script>
                </div>
                <div class="col-md-6">
                    <label for="password">Upload on Google Cloud</label>
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
                    <input type="text" class="form-control" placeholder="Embed Code"  name="embed_code" id="a"/>
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
	<script>
$(document).ready(function(){
  $('#txtInput').bind("paste",function(e) {
      e.preventDefault();
  });
});
</script>
                <input type="text" class="form-control" name="title" id="txtInput" onkeypress="return blockSpecialChar(event)" value="" required />
            </div>

            <div class="well">
                <?php if($errors->first('email')): ?><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh snap!</strong> <?= $errors->first('email'); ?></div><?php endif; ?>
                <label for="email">Video Image Cover Min-(Width:1200px And Height:500px)</label>
                <input type="file" multiple="true" class="form-control" name="file" id="file"  />
            </div>
           
            <div class="well">
                <label for="password">Video Details, Links, and Info</label>
                <textarea class="form-control" placeholder="" name="full" id="full" value="" ></textarea>
            </div>
            <div class="well">
                <label for="password">Short Description</label>
                <textarea class="form-control" placeholder="" name="short" id="short" value="" ></textarea>
            </div>

            <div class="well">
                <label for="password">Category</label>
                <select name="category" id="category" value="" >
                    <?php
                    @$users = DB::select("select * from video_categories");
                    foreach ($users as $user)
                    {
                        ?>
                        <option value="<?php echo $user->id;?>"><?php echo $user->name;?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="well">
                <label for="password">User Access</label>
                <select id="access" name="access" onchange="myFunction()">
                    <option value="guest">Guest (everyone)</option>
                    <option value="registered">Registered Users (free registration must be enabled)</option>
                    <option value="subscriber">Subscriber (only paid subscription users)</option>
                    <option value="premium" >Premium (Premium Video )</option>
                </select>
            </div>
            <div class="well">
                <div class="panel-body" id="hello">
                    <p>Enter Price </p>
                    <input class="form-control" name="price" id="price"  >
                </div>
                <div class="panel-body" id="hello1">
                    <p>Enter Validity</p>
                    <input class="form-control" name="validate1" id="validate1" >
                    <br>
                    <p>Enter Video Trailor</p>
                    <textarea class="form-control" name="trailor_embed_code"  id="trailor_embed_code"></textarea>

                </div>
                <div class="panel-body" id="hello2">
                    <p>Enter Video Trailor</p>
                    <textarea class="form-control" name="trailor_embed_code"  id="trailor_embed_code"></textarea>

                </div>
            </div>

            <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
            <input type="submit" value="Add New Video" class="btn btn-primary" />
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

<?php include('includes/footer.php'); ?>