@extends('admin.master')

@section('content')
<?php

//$a=mysql_query("update users set status=1 where id=10");
?>
	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-user"></i>Assinged Video List</h3><!--<a href="{{ URL::to('admin/user/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>-->
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
			<th>Video</th>
			<th>Type</th>
			<th>Assinged</th>
			
			<!--<th>Subscription Plan</th>-->
			
			
			<?php
			 @$p=Auth::user()->id;
			$users= DB::select("select * from videos where ass=1");
			foreach($users as $user)
			{
			?>
			<tr>
				<td><?php echo $user->title?></td>
				<td><?php echo $user->access?></td>
				<td><a href="" data-toggle="modal" data-target="#<?php echo $user->id?>" class="label label-success delete"><span class="fa fa-user"></span> View</a>
				
				<div class="modal fade" id="<?php echo $user->id?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Assinged Video List</h4>
        </div>
        <div class="modal-body">
       <table class="table table-striped">
	   <tr class="table-header">
			<th>Video</th>
			<th>Type</th>
			<th>User</th>
			<th>Date</th>
			</tr>
			<?php
			$p=DB::select("select * from assignto where video_id='$user->id'");
			foreach($p as $p3)
			{
			?>
			
			<tr>
			<td><?php echo $user->title;?></td>
			<td><?php echo $user->access;?></td>
			<td>
			<?php
			$p1=DB::select("select * from users where id='$p3->user_id'");
			foreach($p1 as $p2)
			{
			?>	
				<?php echo $p2->username;?> (<?php echo $p2->corporate_user;?>)
				
			<?php	
			}	
			?>
			
			</td>
			<td><?php echo @$p3->ass_date;?></td>
			</tr>
			<?php
			}
			?>
	   </table>
		</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
				</td>
				
				
				
			</tr>
			<!-- Modal -->
  
			<?php
			}
			?>
	</table>


	@section('javascript')

	
	

	@stop

@stop

