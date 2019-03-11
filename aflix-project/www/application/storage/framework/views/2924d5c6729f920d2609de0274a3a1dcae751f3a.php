<?php

$access_key         = "AKIAJTKKE62PHTVTDELA"; //Access Key
$secret_key         = "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"; //Secret Key
$my_bucket          = "aflix.amilin.tv"; //bucket name
$region             = "ap-southeast-1"; //bucket region
$success_redirect   = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; //URL to which the client is redirected upon success (currently self)
$allowd_file_size   = "1000048579"; //1 MB allowed Size

//dates
$short_date 		= gmdate('Ymd'); //short date
$iso_date 			= gmdate("Ymd\THis\Z"); //iso format date
$expiration_date 	= gmdate('Y-m-d\TG:i:s\Z', strtotime('+1 hours')); //policy expiration 1 hour from now

//POST Policy required in order to control what is allowed in the request
//For more info http://docs.aws.amazon.com/AmazonS3/latest/API/sigv4-HTTPPOSTConstructPolicy.html
$policy = utf8_encode(json_encode(array(
					'expiration' => $expiration_date,
					'conditions' => array(
						array('acl' => 'public-read'),
						array('bucket' => $my_bucket),
						array('success_action_redirect' => $success_redirect),
						array('starts-with', '$key', ''),
						array('content-length-range', '1', $allowd_file_size),
						array('x-amz-credential' => $access_key.'/'.$short_date.'/'.$region.'/s3/aws4_request'),
						array('x-amz-algorithm' => 'AWS4-HMAC-SHA256'),
						array('X-amz-date' => $iso_date)
						))));

//Signature calculation (AWS Signature Version 4)
//For more info http://docs.aws.amazon.com/AmazonS3/latest/API/sig-v4-authenticating-requests.html
$kDate = hash_hmac('sha256', $short_date, 'AWS4' . $secret_key, true);
$kRegion = hash_hmac('sha256', $region, $kDate, true);
$kService = hash_hmac('sha256', "s3", $kRegion, true);
$kSigning = hash_hmac('sha256', "aws4_request", $kService, true);
$signature = hash_hmac('sha256', base64_encode($policy), $kSigning);


?>

<?php
if(@$_GET['key']!=null)
{
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
$('#myModal1').modal('show');
});
</script>
<?php
}
?>



<?php $__env->startSection('css'); ?>
	<link rel="stylesheet" href="<?php echo e('/application/assets/js/tagsinput/jquery.tagsinput.css'); ?>" />
<?php $__env->stopSection(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>



<?php $__env->startSection('content'); ?>
<?php
if(@$_GET['id']!=null)
{
	$code = DB::select("delete from add_ads where id='".@$_GET['id']."'");
	echo "<script>window.location='/admin/videos/index3'</script>";
}
?>
	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-newspaper"></i> Add Ads</h3><a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal" ><i class="fa fa-plus-circle"></i> Upload On Wistia</a>

				<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
	<form method="post" action="add_ads">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload On Wistia</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped pages-table">
		<tr>
		<td><b>Title</b></td>
		<td><input type="text" name="title" class="form-control" style="border: 1px solid #9c9b9b;" required></td>
		</tr>
		<tr>
		<td><b>Ads Link</b></td>
		<td><input type="text" name="ads_link" class="form-control" style="border: 1px solid #9c9b9b;" ></td>

		<tr>

			<td> <b>Time ( to Show Skip Button ) (HH:MM:SS)</b> </td>
			<td> <input name="time" id="time" placeholder="time" class="form-control" style="border: 1px solid #9c9b9b;" /> </td>
		</tr>
		<tr>
		<input type="hidden" name="type" value="wistia" />
		</tr>
		<tr>
		<td><b>Video</b></td>
		<td>
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
		</td>
		</tr>
		<tr>
			<td><b>Video ID</b></td>
			<td> <input type="text"  class="form-control" name="link" id="a"  readonly > </td>
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		</tr>

		<tr>
		<td colspan="2"><center><input type="submit" name="submit" class="btn btn-success" value="Submit"></center></td>
		</tr>
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</form>
  </div>
</div>

<?php
if(@$_GET['key']==null)
{
?>
<form action="http://<?= $my_bucket ?>.s3.amazonaws.com/" method="post" enctype="multipart/form-data">
<?
}
else
{
?>
<form action="add_ads" method="post" enctype="multipart/form-data">
<?php
}
?>

<div class="modal fade" id="update-add">
	<div class="modal-dialog">
		<div class="modal-content">

		</div>
	</div>
</div>

         <div id="myModal1" class="modal fade" role="dialog" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Ads Aws Server</h4>
      </div>
      <div class="modal-body">
	  <input type="hidden" name="key" value="${filename}" />
<input type="hidden" name="acl" value="public-read" />
<input type="hidden" name="X-Amz-Credential" value="<?= $access_key; ?>/<?= $short_date; ?>/<?= $region; ?>/s3/aws4_request" />
<input type="hidden" name="X-Amz-Algorithm" value="AWS4-HMAC-SHA256" />
<input type="hidden" name="X-Amz-Date" value="<?=$iso_date ; ?>" />
<input type="hidden" name="Policy" value="<?=base64_encode($policy); ?>" />
<input type="hidden" name="X-Amz-Signature" value="<?=$signature ?>" />
<input type="hidden" name="success_action_redirect" value="<?= $success_redirect ?>" />
       <?php
if(@$_GET['key']!=null)
{
?>
       <input type="text" placeholder="Enter Title" class="form-control" name="title" id="title" />
	   <br>
	   <input type="text" name="ads_link" placeholder="Ads Link" class="form-control" style="border: 1px solid #9c9b9b;" >
	   <?php
}
	   ?>
	   <br>
	   <?php
if(@$_GET['key']==null)
{
?>
        <input type="file" multiple="true" class="form-control" name="file" id="file" />
        <br>

		<?php
}
		?>
		<?php
if(@$_GET['key']!=null)
{
?>
<textarea class="form-control" name="link" ><?php echo 'http://'.@$my_bucket.'.s3.amazonaws.com/'.@$_GET["key"].'"';?></textarea>
<?php
}
?>
<br>
		<input type="submit" value="<?php if(@$_GET['key']==null){?>Upload Video<?php }else{ echo "Submit"; } ?>" class="btn btn-success pull-right" />
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		<input type="hidden" name="type" value="aws" />
		<?php
//After success redirection from AWS S3
if(isset($_GET["key"]))
{
	$filename = $_GET["key"];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if(in_array($ext, array("jpg", "png", "gif", "jpeg"))){
		echo '<hr />Image File Uploaded : <br /><img src="http://'.$my_bucket.'.s3.amazonaws.com/'.$_GET["key"].'" style="width:100%;" />';
	}else{
		 '<hr />File Uploaded : <br /><a href="http://'.$my_bucket.'.s3.amazonaws.com/'.$_GET["key"].'">http://'.$my_bucket.'.s3.amazonaws.com/'.$_GET["key"].'</a>



		';

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
</form>
			</div>
			<div class="col-md-4">
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>


	<table class="table table-striped pages-table">
		<tr class="table-header">
			<th>Title</th>
			<th>Uploaded On </th>
      <th> Time ( to show skip button ) </th>
			<th>Status</th>
			<th>Actions</th>

			<?php
			$codes = DB :: select("select * from add_ads order by id desc ");
			foreach($codes as $code)
			{
			?>
			<tr>
				<td><?php echo $code->title;?></td>
				<td><?php echo $code->type;?></td>
				<td> <?php echo (is_null($code->time)) ? '--' : $code->time ?> </td>
				<td>
					<p class="actions">
					<?php if(  ($code->status == '0') ): ?>
						<div class="label label-danger"><i class="fa fa-video-camera"></i> Inactive</div>
					<?php elseif( ($code->status == '1') ): ?>
						<div class="label label-success"><i class="fa fa-video-camera"></i> Active</div>
					<?php endif; ?>
					</p>
				</td>
				<td>
					<p class="actions">

						<a href="/admin/videos/ad/edit/<?php echo e($code->id); ?>"  data-toggle="modal" data-target="#<?php echo $code->id?>" class="edit btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</a>
						<a href="?id=<?php echo $code->id;?>" class="btn btn-xs btn-danger delete"><span class="fa fa-trash"></span> Delete</a>
					</p>
				</td>
			</tr>
			<?php
			}
			?>
	</table>

	<div class="clear"></div>

	<div class="pagination-outter">//pagination</div>
	<script type="text/javascript" src="<?php echo e('/application/assets/js/jquery.mask.min.js'); ?>"></script>
	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('#time').mask('00:00:00');
			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this page?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

		$('.actions .edit').click(function(e){
			$('#update-add').modal('show', {backdrop: 'static'});
			$('#update-add .modal-content').empty();
			e.preventDefault();
			href = $(this).attr('href');
			$.ajax({
				url: href,
				success: function(response)
				{
					$('#update-add .modal-content').html(response);
					$('#time').mask('00:00:00');
				}
			});
		});

	</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>