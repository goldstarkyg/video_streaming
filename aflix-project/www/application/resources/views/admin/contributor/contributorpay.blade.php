@extends('admin.master')

@section('content')
<?php
if(@$_GET['id']!="")
{
@$updatepay = DB::select("update month_wise_subscrition set status='1' where user_id='".$_GET['id']."' AND month='".$_GET['month']."' AND year='".$_GET['year']."'");
}
?>
	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-user"></i> Manage Payment For Subscribe Video</h3><!--<a href="{{ URL::to('admin/user/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>-->
			</div>
			<div class="col-md-4">
				<?php $search = request('s'); ?>
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" value="@if(!empty($search)){{ $search }}@endif" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>

    <?php
	if(@$_GET['month']=="")
	{
	?>
	<table class="table table-striped">
		<tr class="table-header">
			<th>Sr No.</th>
			<th>User Name</th>
			<th>From Admin Video</th>
			<th>From Contributor Video</th>
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
			?>
			<?php
			$time=strtotime(date('Y-m-d'));
  $month1=date("F",$time);
 $year1=date("Y",$time);
			@$email=Auth::user()->email;

			@$month = DB::select("select * from admin_subscription");
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
			$contributor_views=0;
			foreach($video as $vid)
			{

           if($month1==$mon->month AND $year1==$mon->year)
		   {

		        $contributor_views=$contributor_views+$vid->views;

			  }


			}
			    $contributor_views;
			?>

			<?php
			@$e=Auth::user()->id;
							$time=strtotime(date('Y-m-d'));
  $month1=date("F",$time);
 $year1=date("Y",$time);
			@$video3 = DB::select("select * from views where video_type='subscriber' AND view_date='".$month1."' AND year='".$year1."'");
			$overall_view="";
			foreach($video3 as $vid3)
			{
		       $overall_view=$overall_view+$vid3->views;
			}
			   @$allview=@$contributor_views/@$overall_view;


			 @$video10 = DB::select("select * from users where role='subscriber' AND plan!='' AND plan_price!=''");
			 $plan="";
			 foreach($video10 as $vid10)
			 {
		      $plan=$plan+$vid10->plan_price;
			 }

			   @$contributor_views;

			  @$allview1=@$allview*@$plan;

			@$total=@$allview1;//*60/100;
			    echo "$".@$total=number_format((float)$total, 2, '.', '');

			  			  //@$update = DB::select("update admin_subscription set from_admin='".$total."',st_date=now() where user_id='".$e."' AND month='".$mon->month."' AND year='".$mon->year."'");






			?>
			</td>

			<td>
			<?php
			 @$e=Auth::user()->id;

			@$video = DB::select("select * from views where video_type='subscriber' AND view_date='".$month1."' AND year='".$year1."'");
			$contributor_views="";
			foreach($video as $vid)
			{

			 if($vid->user_id==$e)
			 {
			 }
			 else
			 {
			 $time=strtotime($vid->view_date);
              $month=date("F",$time);
              $year=date("Y",$time);

           if($month1==$mon->month AND $year1==$mon->year)
		   {
		       $contributor_views=$contributor_views+$vid->views;
			  }
			  }
			}
			  $contributor_views;
			?>

			<?php
			@$e=Auth::user()->id;

			@$video3 = DB::select("select * from views where video_type='subscriber' AND view_date='".$month1."' AND year='".$year1."'");
			$overall_view="";
			foreach($video3 as $vid3)
			{
		       $overall_view=$overall_view+$vid3->views;
			}
			   @$allview=$contributor_views/@$overall_view;


			 @$video10 = DB::select("select * from users where role='subscriber' AND plan!='' AND plan_price!=''");
			 $plan="";
			 foreach($video10 as $vid10)
			 {
		      $plan=$plan+$vid10->plan_price;
			 }

			   $contributor_views;

			  $allview1=$allview*$plan;
			$p1=100-$rvsu;
			$total=$allview1*$p1/100;
			    echo "$".$total=number_format((float)$total, 2, '.', '');

			  			  //@$update = DB::select("update admin_subscription set from_contributor='".$total."',st_date=now() where user_id='".$e."' AND month='".$mon->month."' AND year='".$mon->year."'");






			?>
			</td>
			<td>
			<?php
			if($total==0.00)
			{
			?>

			<?php
			}
			else
			{
			?>
			<a href="?month=<?php echo $mon->month;?>&year=<?php echo $mon->year;?>" class="label label-success"> View Detail </a>
			<?php
			}
			?>
			</td>
			</tr>
			<?php
			}
			?>

	</table>
	<?php
	}
	else
	{
	?>
    <table class="table table-striped">
		<tr class="table-header">
			<th>Sr No.</th>
			<th>User Name</th>
			<th>Month</th>
			<th>Total Revenue </th>
			<!--<th>Subscription Plan</th>-->
			<th> Payment Status</th>


			<?php

			@$email=Auth::user()->email;

			@$month = DB::select("select * from month_wise_subscrition where month='".$_GET['month']."' AND year='".$_GET['year']."'");
			$i=0;
			foreach($month as $mon)
			{
			$i=$i+1;
			if($mon->total_subscription!=0.00)
			{
			?>
			<tr>
			<td><?php echo $i;?></td>

			<td>
			<?php
			@$users = DB::select("select * from users where email='".$mon->user_id."'");
			$i=0;
			foreach($users as $user)
			{
			echo $user->username;
			}
			?></td>

			<td>

			<?php echo $mon->month;?> - <?php echo $mon->year;?>
			</td>

			<td>

			<?php

			echo "$".$mon->total_subscription;

			?>
			</td>
			<td>
			<?php
			if($mon->status==0)
			{
			?>
			<a href="?id=<?php echo $mon->user_id;?>&month=<?php echo  $mon->month;?>&year=<?php echo  $mon->year;?>" class="label label-success" style="background-color:red;"> Realise Payment </a>
			<?php
			}
			else
			{
			?>
			<a href="#" class="label label-success"> Payment Done </a>
			<?php
			}
			?>
			</td>
			</tr>
			<?php
			}
			}
			?>

	</table>
    <?php
	}

	?>
	@section('javascript')

	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete1').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to Block this user?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>
	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to Active this user?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>

	@stop

@stop
