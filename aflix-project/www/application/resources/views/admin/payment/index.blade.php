@extends('admin.master')

@section('content')
<?php

//$a=mysql_query("update users set status=1 where id=10");
?>
	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-user"></i> Manage Payment For Premium Video</h3><!--<a href="{{ URL::to('admin/user/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>-->
			</div>
			<div class="col-md-4">
				<?php $search = request('s'); ?>
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" value="@if(!empty($search)){{ $search }}@endif" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>


	<table class="table table-striped">
		<tr class="table-header">
			<th>Sr No.</th>
			<th>User Name</th>
			<th>Admin Payment</th>
			<th>Contributor Payment</th>
			<!--<th>Subscription Plan</th>-->
			<th>Status</th>

			<?php

			$sql ="select * from users where contribute!=''";

			if(request()->has('s')){
				if(!empty(request('s'))){
					$sql .= " and username like '%".request('s')."%'";
				}
			}
			$users = DB::select($sql);
			$i=0;

			foreach($users as $user)
			{
			$i=$i+1;
			?>
			<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $user->username;?></td>
			<td>
			<?php
			$returned_money = DB::select("select sum(video_price) as r from premium_video where user_id=".$user->id)[0];

			$percentages = DB::select("select * from contributer_tb where user_id =".$user->id." limit 1");

			$percentages = (count($percentages)) ? $percentages[0] : (object) ['premium_video' => 0];

			if($user->role =="admin")
			{
			echo "$". $returned_money->r;

			}

			if($user->contribute=="contribute")
			{
			$adminrv=100-$percentages->premium_video;
			echo "$". $a=$returned_money->r*$adminrv/100;

			}

			$b=$returned_money->r*$percentages->premium_video/100;
			?>
			</td>
			<td>
			<?php
            if($user->contribute=="contribute")
			{
			echo "$". $b;
			}
			?>
			</td>
			<td><!--<a href="#" class="label label-success delete"> Paid </a>--></td>
			</tr>
			<?php
			}
			?>

	</table>


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
