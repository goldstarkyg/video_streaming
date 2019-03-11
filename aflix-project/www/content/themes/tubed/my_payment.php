<?php include('includes/header.php'); ?>


	<h3 class="col-md-10 col-md-offset-2 right-content-10 header"><?php echo "My Payment"; ?><?php if(isset($page_description)): ?><span><?= $page_description ?></span><?php endif; ?></h3>


<div class="col-md-offset-2 col-md-10 right-content-10">

		<div class="row" >
		 
         <div class="col-md-12 col-sm-12 col-xs-12 loop">
		 
		 <h4 class="" style="margin:0px; margin-bottom:26px;"><?php echo "Revenue From Premium Videos "; ?></h4>
		 <table class="table table-striped" style="background-color:#fff;">
		<tr class="table-header">
			<th>Sr No.</th>
			<th>Contribute Video</th>
			
			<th>Contributor Payment</th>
			<!--<th>Subscription Plan</th>-->
			<th>Status</th>
			
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
			@$p=Auth::user()->id;
							 @$p;
			@$users = DB::select("select * from premium_video where user_id='$p'");
			$i=0;
			
			foreach($users as $user)
			{
			$i=$i+1;
			?>
			<tr>
			<td><?php echo $i;?></td>
			<td>
			<?php 
			@$video = DB::select("select * from videos where id='".$user->video_id."'");
			foreach($video as $vid)
			{
			echo $vid->title;
			}
			?>
			</td>
			
			<td>
			
			<?php
			
			echo "$".$b=$user->video_price*$rv/100;
            
			?>
			</td>
			<td><!--<a href="#" class="label label-success delete"> Paid </a>--></td>
			</tr>
			<?php
			}
			?>
			
	</table>
		 
		
      
	  <h4 class="" style="margin:0px; margin-bottom:26px; margin-top: 26px;"><?php echo "Revenue From Subscribers "; ?></h4>
		 <table class="table table-striped" style="background-color:#fff;">
		<tr class="table-header">
			<th>Sr No</th>
			<th>Month</th>
			<th>Contributor Payment</th>
			<!--<th>Subscription Plan</th>-->
			<th>Status</th>
			
			<?php
			
			@$revenue = DB::select("select * from contributer_tb");
			$rv="";
			$rvsu="";
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
			
			if($rvsu=="")
			{
			 $rvsu=$rvsu=$rev->subscribe_video	;
			}
			else
			{
			 $rvsu=$rev->subscribe_video	;
			}
			}
			@$p=Auth::user()->id;
							 @$p;
			
			?>
			<!--Start payment-->
			
			<!--End Payment-->
			<?php
			$time=strtotime(date('Y-m-d'));
  $month1=date("F",$time);
 $year1=date("Y",$time);
			@$email=Auth::user()->email;
							
			@$month = DB::select("select * from month_wise_subscrition where user_id='".$email."'");
			$i=0;
			foreach($month as $mon)
			{
			$i=$i+1;
			?>
			<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $mon->month;?> - <?php echo $mon->year;?></td>
			
			<td>
			<?php 
			@$e=Auth::user()->id;
							
			@$video = DB::select("select * from views where user_id='".$e."' AND video_type='subscriber' AND view_date='".$month1."' AND year='".$year1."'");
			$contributor_views="";
			foreach($video as $vid)
			{
			 
			 $time=strtotime($vid->view_date);
  $month=date("F",$time);
 $year=date("Y",$time);

           if($month1==$mon->month AND $year1==$mon->year)
		   {
		       @$contributor_views=$contributor_views+$vid->views;
			  }
			}
			  @$contributor_views;
			?>
			
			<?php 
			@$e=Auth::user()->id;
							
			@$video3 = DB::select("select * from views where video_type='subscriber' AND view_date='".$month1."' AND year='".$year1."'");
			$overall_view="";
			foreach($video3 as $vid3)
			{
		       @$overall_view=@$overall_view+@$vid3->views;
			}
			  @$allview=@$contributor_views/@$overall_view;
			 
			 
			 @$video10 = DB::select("select * from users where role='subscriber' AND plan!='' AND plan_price!=''");
			 $plan="";
			 foreach($video10 as $vid10)
			 {
		      $plan=$plan+$vid10->plan_price;
			 }
			
			   @$contributor_views;
			 
			  @$allview1=@$allview*$plan;
			
			 @$total=@$allview1*@$rvsu/100;
			  echo  "$".$total=number_format((float)$total, 2, '.', '');
			   
			  			  @$update = DB::select("update month_wise_subscrition set total_subscription='".$total."',st_date=now() where user_id='".$email."' AND month='".$mon->month."' AND year='".$mon->year."'");
			 
			
			
			
			 

			?>
			</td>
			<td>
			<?php
			if($mon->total_subscription==0.00)
			{
			
			}
			elseif($mon->status==0)
			{
			?>
			<a  class="label label-success delete"> Remaining Payment </a>
			<?php
			}
			else
			{
			?>
			<a  class="label label-success delete"> Paid </a>
			<?php
			}
			?>
			</td>
			</tr>
			<?php
			}
			?>
			
			
			
	</table>
		
	</div>
			

		</div>


	<?php //include('partials/pagination.php'); ?>

</div>


<?php include('includes/footer.php'); ?>