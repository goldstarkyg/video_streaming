@extends('admin.master')

@section('content')

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-user"></i>All Users</h3><!--<a href="{{ URL::to('admin/user/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>-->
			</div>
			<div class="col-md-4">
				<?php $search = request('s'); ?>
				<form method="get" role="form" class="search-form-full"> <div class="form-group">
					<input type="text" class="form-control" name="s" id="search-input" value="@if(!empty($search)){{ $search }}@endif" placeholder="Search...">
					   <i class="entypo-search"></i>
					 </div>


					 <hr />

						<div class="form-group" >
						  <label for="sel1">Select Role:</label>
						  <select class="form-control" name="role">
								<option value="all" {{ (request('role') == 'all') ? 'selected' : ''}}>All</option>
	              <option value="subscriber" {{ (request('role') == 'subscriber') ? 'selected' : ''}}>Subscriber</option>
	              <option value="registered" {{ (request('role') == 'registered') ? 'selected' : ''}}>Registered</option>
	              <option value="demo" {{ (request('role') == 'demo') ? 'selected' : ''}}>Demo</option>
	              <option value="admin" {{ (request('role') == 'admin') ? 'selected' : ''}}>Admin</option>
								<option value="corporate" {{ (request('role') == 'corporate') ? 'selected' : ''}}>Corporate</option>
	              <option value="corporate_admin" {{ (request('role') == 'corporate_admin') ? 'selected' : ''}}>Corporate Admin</option>
	              <option value="contributor" {{ (request('role') == 'contributor') ? 'selected' : ''}}>Contributor</option>
						  </select>
						</div>

						<div class="checkbox">
							 <!--<label>
								 <input type="checkbox"  name="paid" value="1" {{ (request('paid')) ? 'checked' : ''}}> Paid User
							 </label>-->
						 </div>

						 <button type="submit" class="btn btn-default" role="button">Search</button>
						 <a href="{{ $_SERVER['REQUEST_URI'] }}{{ (count($_GET)) ? '&' : '?' }}export=1" class="btn btn-default" role="button" style="margin:0;">Export To CSV</a>


				 </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>


	<table class="table table-striped">
		<tr class="table-header">
			<th>Username</th>
			<th>Email</th>
			<th>User Type</th>
			<!--<th>Subscription Plan</th>-->
			<th>Subscription Date</th>
			<th>End Subscription Date</th>
			<th>Premium Video</th>
			<th>Status</th>
			<th>Actions</th>
			<?php
			if(count($users) > 0){
			foreach($users as $user)
			{
			?>

			<tr>
				<td><a href="{{ URL::to('user') . '/' . $user->username }}" target="_blank">
					<?php if(strlen($user->username) > 40){
							echo substr($user->username, 0, 40) . '...';
						  } else {
						  	echo $user->username;
						  }
					?>
					</a>
				</td>
				<td>@if(Auth::user()->role == 'demo')email n/a in demo mode @else{{ $user->email }}@endif</td>
				<td>
				   <?php
				   if($user->corporate_user=="")
				   {
				   ?>
					@if($user->role == 'subscriber')
						<div class="label label-success"><i class="fa fa-user"></i>
						Subscribed User <?php if($user->contribute!=''){ echo " / Contributor"; }?></div>
					@elseif($user->role == 'registered')
						<div class="label label-info"><i class="fa fa-envelope"></i>
						Registered User <?php if($user->contribute!=''){ echo " / Contributor"; }?></div>
					@elseif($user->role == 'demo')
						<div class="label label-danger"><i class="fa fa-life-saver"></i>
						Demo User</div>
					@elseif($user->role == 'admin')
						<div class="label label-primary"><i class="fa fa-star"></i>
						<?= ucfirst($user->role) ?> User</div>
					@endif
					 <?php
					 }
					 elseif($user->corporate_user=="Corporate_Admin")
					 {
					 ?>
					 <div class="label label-success" style="background-color:#000;"><i class="fa fa-user" ></i> Corporate Admin</div>
					 / <a href="users/corporate_user?id=<?php echo $user->id;?>">View Corporate User <?php if($user->organization_name !='') echo "(".$user->organization_name.")" ; ?></a>
					 <?php
					 }
					 else
					 {
					 ?>
					 <div class="label label-success"><i class="fa fa-user"></i> Corporate User()</div>
					    <?php if($user->organization_name !='')echo "/(".$user->organization_name.")" ; ?></a>
					 <?php
					 }
					 ?>
				</td>
				<!--<td>

				<?php $users1 = DB::select("select * from subscribe_plane where id='$user->plan'");
			foreach ($users1 as $user1) {
			echo $user1->title;
			}
			?></td>-->
				<td><?php if($user->start_plan=="2060-01-01" || $user->role == "registered"){ "";}else{ echo $user->start_plan;}?></td>
				<td><?php if($user->end_plan=="2060-01-01" || $user->role == "registered"){ "";}else{echo $user->end_plan;}?></td>
				<td>
				<?php $users2 = DB::select("select * from premium_video where userid='$user->email'");
				$i=0;
			foreach ($users2 as $user2) {
			 $i=$i+1;
			}
			echo $i;
			?>

			<a href="" data-toggle="modal" data-target="#<?php echo $user->id;?>">View</a>

  <!-- Modal -->
  <div class="modal fade" id="<?php echo $user->id;?>" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">User Name : <?php echo $user->username;?></h4>
        </div>
        <div class="modal-body">
        <table class="table table-striped">
		<tr class="table-header">
		<th>Video Name</th>
		<th>Video Amount</th>
		<th>Purchase Date</th>
		<th>End Date </th>
		</tr>
		<?php $users3 = DB::select("select * from premium_video where userid='$user->email' AND video_type!=''");
				$i=0;
			foreach ($users3 as $user3) {

			?>
		 <tr>
		 <td>
		 <?php
		 $users5 = DB::select("select * from videos where id='$user3->video_id' ");
				$i=0;
			foreach ($users5 as $user5) {
 		 echo $user5->title;
		 }
		 ?>
		 </td>
		 <td> $</b><?php echo $user3->video_price;?> </td>
		 <td> </b><?php echo $user3->creat_date;?> </td>
		 <td><?php echo $user3->end_date;?></td>
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

				<td>

					@if(  ($user->status == '0') )
						<div class="label label-danger"><i class="fa fa-user"></i> Inactive</div>

					@elseif( ($user->status == '1') )
						<div class="label label-success"><i class="fa fa-user"></i> Active</div>
					@endif
				</td>
				<td>
				<?php
				   if( $user->corporate_user=="Corporate_Admin" || $user->contribute == 'contribute')
				   {
				   ?>
					<a href="{{ URL::to('admin/user/edit1') . '/' . $user->id }}" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> View / Edit</a>
					<?php
					}
					else
					{
					?>
					<a href="{{ URL::to('admin/user/edit') . '/' . $user->id }}" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> View / Edit</a>
					<?php
					}
					?>
					@if( ($user->status == '1'))
					<a href="{{ URL::to('admin/user/editstatus1') . '/' . $user->id }}" class="btn btn-xs btn-danger delete1"><span class="fa fa-user"></span> Block</a>
					@elseif( ($user->status == '0') )
					<a href="{{ URL::to('admin/user/editstatus') . '/' . $user->id }}" class="label label-success delete"><span class="fa fa-user"></span> Active</a>
					@endif
					<?php
					if($user->adm!="admin")
					{
					?>
					<a href="{{ URL::to('admin/user/delete') . '/' . $user->id }}" class="btn btn-xs btn-danger delete2"><span class="fa fa-user"></span>Delete</a>
					<?php
					}
					?>
				</td>
			</tr>
			<?php
			}}else{
			?>
				<tr><td colspan="8"><center><h3>No User Found............</h3></center></td></tr>
			<?php
			}
			?>
	</table>

	<div class="pagination-outer">
		{{ $users->appends(['s' => request('s') , 'role' => request('role') , 'paid' => request('paid')])->links() }}

	</div>

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

	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete2').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to Delete this user?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>

	@stop

@stop
