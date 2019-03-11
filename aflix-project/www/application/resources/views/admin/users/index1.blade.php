@extends('admin.master')

@section('content')
<?php

//$a=mysql_query("update users set status=1 where id=10");
?>
	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-user"></i>Corporate User</h3><!--<a href="{{ URL::to('admin/user/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>-->
			</div>
			<div class="col-md-4">
				<?php $search = request('s'); ?>
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" value="@if(!empty($search)){{ $search }}@endif" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<form method="post" action="user_actions">
		<div class="actions" style="display:none;">
			<select name="action" class="form-control">
				<option value="send_mail">Send Mail</option>
				<option value="delete">Delete</option>
			</select>
			<br>
			<input type="submit" class="btn btn-success pull-left" value="Do Action" style="margin-bottom: 14px;">
		</div>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	 <script>
	 $(document).ready(function () {
    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    });

		$(".checkBoxClass , #ckbCheckAll").on('change' , function(){
        var any = $(".checkBoxClass").is(':checked');
				(any) ? $('.actions').fadeIn() : $('.actions').fadeOut();
		});
});
</script>
<?php
@$p=Auth::user()->id;
$users= HelloVideo\User::where('user_id' , $p)->paginate(10);
?>


	<table class="table table-striped">
		<tr class="table-header">
		    <th><input type="checkbox" id="ckbCheckAll" name="allcheck"> Select All</th>
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

			foreach($users as $user)
			{

					echo "<input type='hidden' name='user_email[]' value='$user->email'>";
				  echo "<input type='hidden' name='user_pwd[]' value='$user->demo'>";
				  echo "<input type='hidden' name='username[]' value='$user->username'>";

			?>
			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<tr>
			<td><input type="checkbox" class="checkBoxClass" value="1" name="check[]"><?php if($user->mail_status==""){?> <b style='color:red;'>Mail Sent</b> <?php }else{ echo "<b style='color:green;'>Mail Already Sent</b>"; } ?></td>
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
				   if($user->corporate_user!="")
				   {
				   ?>
					 <div class="label label-success"><i class="fa fa-user"></i>Corporate User</div>
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
				<td><?php if($user->end_plan=="2060-01-01" || $user->role == "registered"){ "";}else{ echo $user->end_plan;}?></td>
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

					<a href="{{ URL::to('admin/user/edit2') . '/' . $user->id }}" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> View / Edit</a>

					@if( ($user->status == '1'))
					<a href="{{ URL::to('admin/user/editstatus3') . '/' . $user->id }}" class="btn btn-xs btn-danger delete1"><span class="fa fa-user"></span> Block</a>
					@elseif( ($user->status == '0') )
					<a href="{{ URL::to('admin/user/editstatus2') . '/' . $user->id }}" class="label label-success delete"><span class="fa fa-user"></span> Active</a>
					@endif
				</td>
			</tr>
			<?php
			}
			?>
	</table>
</form>

<div class="pagination-outer">
	{{ $users->links() }}
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

	@stop

@stop
