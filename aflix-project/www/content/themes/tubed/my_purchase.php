<?php include('includes/header.php'); ?>


	<h3 class="col-md-10 col-md-offset-2 right-content-10 header"><?php echo "My Purchase"; ?><?php if(isset($page_description)): ?><span><?= $page_description ?></span><?php endif; ?></h3>


<div class="col-md-offset-2 col-md-10 right-content-10">

		<div class="row" >

         <div class="col-md-12 col-sm-12 col-xs-12 loop">
		 <?php
		 @$p=Auth::user()->email;
							 @$p;
		 @$auths = DB::select("select * from premium_video where userid='$p'");
		    $email="";
			foreach($auths as $auth)
			{
			if($email=="")
			{
			$email=$email=$auth->userid;
			}
			}
			if($email!=null)
			{
		 ?>
		<h4 class="" style="margin:0px; margin-bottom:26px;"><?php echo "Purchased Premium Video Details"; ?></h4>
	  <table class="table table-striped" style="background-color:#fff;">
		<tr class="table-header" >

			<th>Video Name</th>
			<th>Price</th>
			<th>Start Date</th>
			<th>End Date</th>
			<!--<th>Subscription Plan</th>-->

			<?php

			@$revenue = DB::select("select * from contributer_tb");
			$rv="";
			foreach($revenue as $rev)
			{
			if($rv=="")
			{
			 $rv=$rv=$rev->premium_video;
			}
			else
			{
			 $rv=$rev->premium_video;
			}
			}
			@$p=Auth::user()->email;
							 @$p;
			@$users = DB::select("select * from premium_video where userid='$p'");
			$i=0;

			foreach($users as $user)
			{

			?>
			<tr>

			<td><?php
			@$video = DB::select("select * from videos where id='".$user->video_id."'");
			foreach($video as $vid)
			{
			echo $vid->title;
			}
			?></td>
			<td>
			<?php echo "$".$user->video_price; ?>
			</td>
			<td>
			<?php
            echo $user->creat_date;
			?>
			</td>
			<td><?php echo $user->end_date; ?></td>
			</tr>
			<?php
			}
			?>

	</table>
    <?php
	}
	?>
	<?php
	@$auths1 = DB::select("select * from users where email='$p'");
		    $plan="";
			foreach($auths1 as $auth1)
			{
			if($plan=="")
			{
			$plan=$plan=$auth1->plan;
			}
			}
			if($plan!=0)
			{
			?>
	 <h4 class="" style="margin:0px; margin-bottom:26px;"><?php echo "Subscribe Detail"; ?></h4>
	  <table class="table table-striped" style="background-color:#fff;">
		<tr class="table-header" >

			<th>Plan</th>
			<th>Price</th>
			<th>Start Date</th>
			<th>End Date</th>
			<!--<th>Subscription Plan</th>-->

			<?php

			$user_id = Auth::user()->id;
			
			@$revenue = DB::select("select * from contributer_tb where user_id = $user_id");
			$rv="";
			foreach($revenue as $rev)
			{
			if($rv=="")
			{
			 $rv=$rev->premium_video;
			}
			else
			{
			 $rv=$rev->premium_video;
			}
			}
			 @$p=Auth::user()->email;
							 @$p;
			@$users = DB::select("select * from users where email='$p'");
			$i=0;
			foreach($users as $user)
			{

			?>
			<tr>

			<td><?php
			@$video = DB::select("select * from subscribe_plane where id='".$user->plan."'");
			foreach($video as $vid)
			{
			echo $vid->title;

			?></td>
			<td>
			<?php echo "$".$vid->amount; ?>
			</td>
			<?php
			}
			?>
			<td>
			<?php
            echo $user->start_plan;
			?>
			</td>
			<td><?php echo $user->end_plan; ?></td>
			</tr>
			<?php
			}
			?>

	</table>
<?php
}
?>

	</div>


		</div>


	<?php //include('partials/pagination.php'); ?>

</div>


<?php include('includes/footer.php'); ?>
