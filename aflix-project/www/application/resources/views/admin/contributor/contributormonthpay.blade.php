@extends('admin.master')
@section('css')
	<link rel="stylesheet" href="{{ '/application/assets/admin/css/sweetalert.css' }}">
@endsection
@section('content')
<style>
.error-input { border: 1px solid #FF0000; }
</style>
<?php
if(@$_GET['id']!="")
{
@$updatepay = DB::select("update month_wise_subscrition set status='1' where user_id='".$_GET['id']."' AND month='".$_GET['month']."' AND year='".$_GET['year']."'");
}
?>
	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-user"></i> Manage Contributor Monthly Payment</h3><!--<a href="{{ URL::to('admin/user/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>-->
				<!-- Example single danger button -->
				<!-- Example split danger button -->
			</div>
			<div class="col-md-4">
				<div class="btn-group" id="myDropdown">
				  <a class="btn btn btn-info dropdown-toggle" data-toggle="dropdown" href="#">
					Action
					<span class="caret"></span>
				  </a>
				  <ul class="dropdown-menu">
					<li><a href="javascript:;" id="make_payment">Make Payment</a></li>
				  </ul>
				</div>
			</div>
		</div>	
		<hr>
		<div class="row">
			<div class="col-md-8">
			</div>
			<div class="col-md-4">
				<form method="get" role="form" class="search-form-full">
					<div class="form-group" >
						<select class="form-control" name="month">
							<option value="1" {{ $month == 1 ? 'selected' : ''}}>January</option>
							<option value="2" {{ $month == 2 ? 'selected' : ''}}>February</option>
							<option value="3" {{ $month == 3 ? 'selected' : ''}}>March</option>
							<option value="4" {{ $month == 4 ? 'selected' : ''}}>April</option>
							<option value="5" {{ $month == 5 ? 'selected' : ''}}>May</option>
							<option value="6" {{ $month == 6 ? 'selected' : ''}}>June</option>
							<option value="7" {{ $month == 7 ? 'selected' : ''}}>July</option>
							<option value="8" {{ $month == 8 ? 'selected' : ''}}>August</option>
							<option value="9" {{ $month == 9 ? 'selected' : ''}}>September</option>
							<option value="10" {{ $month == 10 ? 'selected' : ''}}>October</option>
							<option value="11" {{ $month == 11 ? 'selected' : ''}}>November</option>
							<option value="12" {{ $month == 12 ? 'selected' : ''}}>December</option>
						</select>
						<button style=" margin-top:10px;" type="submit" class="btn btn-default" role="button">Get Revenue</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="clear"></div>

    <table class="table table-striped" id="contributorpayment">
		<tr class="table-header">
		    <th><input type="checkbox" id="select_all" name="select_all"></th>
			<th>Sr No.</th>
			<th>User Name</th>
			<th>Month</th>
			<th>Earned Amount </th>
			<th>Amount To Pay </th>
			<th>Paid Amount </th>
			<th>Payment Status</th>
			<th>Action</th>
        </tr>
		<?php if(count($results) > 0){ 
		       $i = 1;
			  foreach($results as $result){
		   
		?>
			<tr class="content_<?php echo $result->id;?>">
			    <td><input type="checkbox" id="check_<?php echo $i;?>" class="usercheckbox" name="check_individual" value="<?php echo $result->id;?>"></td>
				<td><?php echo $i; ?></td>
				<td>
					<?php
						$user = DB::select("select username from users where id='$result->user_id'") ;
						echo $user[0]->username;
					?>
				</td>
				<td>
				    <?php 
				        $nmonth = date("F", strtotime(date("Y")."-".$result->month."-01"));
				        echo $nmonth; 
					?>
				</td>
				<td><?php echo $result->earned_amount ?></td>
				<td><?php echo $result->final_amount ?></td>
				<td><?php echo $result->paid_amount ?></td>
				<td>
					<?php 
						if($result->payment_status == 1) {
							echo "Done";
						}elseif($result->payment_status == 2){
							echo "Partialy Done";
						}elseif($result->payment_status == 3){
							echo "Hold";
						}elseif($result->payment_status == 4){
							echo "Canceled";
						}elseif($result->payment_status == 5){
							echo "Rejected";
						}elseif($result->payment_status == 6){
							echo "Pending";
						}     
					?>
				</td>
				<td>
				   <a href="javascript:;" class="btn btn-primary update_amount_to_pay" record_id="<?php echo $result->id;?>">Update Amount</a>
				   <a href="javascript:;" class="btn btn-danger update_payment_status" record_id="<?php echo $result->id;?>">Update Payment Status</a>
				</td>
				<input type="hidden" name="payment_month" value="<?php echo $result->month;?>" id="payment_month" >
				<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" id="_token">
			</tr>
		<?php $i++;}}else{ ?>	
            <tr colspan="6">
				<td>No Data To Display....</td>
			</tr>
		<?php } ?>		
	</table>
	<!-----------------payment model start----------------------------->
    <div id="updatepayment" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Update Payment</h4>
				</div>
				<div class="modal-body">
					  <form id="loginForm" method="post" class="form-horizontal">
						<div class="form-group">
							<label class="col-xs-3 control-label">Current Paid Amount</label>
							<div class="col-xs-5">
								<input type="number" step="any" class="form-control" name="current_paid_amount" id="current_paid_amount"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-3 control-label">Update Paid Amount</label>
							<div class="col-xs-5">
								<input type="number" step="any" class="form-control" name="updated_paid_amount" id="updated_paid_amount" />
							</div>
						</div>
						<input type="hidden" name="update_record_id" id="update_record_id" value="">
						<div class="form-group">
							<div class="col-xs-5 col-xs-offset-3">
								<button type="button" class="btn btn-primary submit_update_amount_data">Update</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!----------------- payment model end----------------------------->
	<!-----------------payment model start----------------------------->
    <div id="updatepaymentstatus" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Update Payment Status</h4>
				</div>
				<div class="modal-body">
					  <form id="loginForm" method="post" class="form-horizontal">
						<div class="form-group">
							<select class="selectpicker form-control" name="updated_payment_status" id="updated_payment_status">
								<option value="1">Done</option>
								<option value="2">Partialy Done</option>
								<option value="3">Hold</option>
								<option value="4">Canceled</option>
								<option value="5">Rejected</option>
								<option value="6">Pending</option>
							</select>
						</div>
						<hr>
						<input type="hidden" name="statusupdate_record_id" id="statusupdate_record_id" value="">
						<div class="form-group">
							<div class="col-xs-5 col-xs-offset-3">
								<button type="button" class="btn btn-primary submit_update_payment_status">Update</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!----------------- payment model end----------------------------->
	@section('javascript')
    <script src="{{ '/application/assets/admin/js/sweetalert.min.js' }}"></script>
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
			
			//update amount to be paid model
			$('.update_amount_to_pay').click(function(){
				var record_id = $(this).attr('record_id');
				var current_paid_amount = $('table .content_'+record_id+' td').eq(5).html();
				$('#current_paid_amount').val(current_paid_amount);
				$('#updated_paid_amount').val(current_paid_amount);
				$('#update_record_id').val(record_id);
				$('#updatepayment').modal('show');
			});
			
			
			//open update payment status model
			$('.update_payment_status').click(function(){
				var currentstatus = $.trim($(this).parent().prev('td').html());
				$("#updated_payment_status option:contains(" + currentstatus +")").attr("selected", 'selected');
				var record_id = $(this).attr('record_id');
				$('#statusupdate_record_id').val(record_id);
				$('#updatepaymentstatus').modal('show');
			});
			
			// submit update payment model
			$('.submit_update_amount_data').click(function(){
				var current_paid_amount = $('#current_paid_amount').val();
				var updated_paid_amount = $('#updated_paid_amount').val();
				var id = $('#update_record_id').val(); 
				var _token = $('#_token').val();
                var currobj = $(this);				
				var error = false;
				
				if(current_paid_amount == ''){
					$('#current_paid_amount').addClass('error-input');
					error = true;
				}else{
					$('#current_paid_amount').removeClass('error-input');
					error = false;
				}
				
				if(updated_paid_amount == ''){
					$('#updated_paid_amount').addClass('error-input');
					error = true;
				}else{
					$('#updated_paid_amount').removeClass('error-input');
					error = false;
				}
				if(error == false){
					$.ajax({
						url: '/admin/payment/updatecontributoramount',
						type: 'POST',
						data: {'_token':_token, 'current_paid_amount':current_paid_amount, 'updated_paid_amount':updated_paid_amount, 'id':id},
						success: function(response) {
							$('#updatepayment').modal('hide');
							if(response == 'success'){
								$('table .content_'+id+' td').eq(5).html(updated_paid_amount);
								toastr.success('Cotributor To Be Paid Amount Updated Succsfully..!')
							}else{
								toastr.error('Cotributor To Be Paid Amount Could Not Be Updated..!')
							}
						}
					});
				}
			})
			
			// submit update payment status model
			$('.submit_update_payment_status').click(function(){
				var status  = $('#updated_payment_status').val();
				var text    = $.trim($('#updated_payment_status option:selected').text());
				var id      = $('#statusupdate_record_id').val(); 
				var _token  = $('#_token').val();
                var currobj = $(this);				
				var error = false;
				if(error == false){
					$.ajax({
						url: '/admin/payment/updatecontributorpaymentstatus',
						type: 'POST',
						data: {'_token':_token, 'status':status, 'id':id},
						success: function(response) {
							$('#updatepaymentstatus').modal('hide');
							if(response == 'success'){
								$('table .content_'+id+' td').eq(7).html(text);
								toastr.success('Cotributor Payment Status Updated Succsfully..!')
							}else{
								toastr.error('Cotributor Payment Status Could Not Be Updated..!')
							}
						}
					});
				}
			})
			
			//check box functionality to check all select box
			$('#select_all').change(function () {
				if ($(this).prop('checked')) {
				$('input').prop('checked', true);
				}
				else {
					$('input').prop('checked', false);
				}
			});
			$('#select_all').trigger('change');
			// make payment for all users
			$('#make_payment').click(function(){
				var selecteduser = [];
				$('.usercheckbox:checked').each(function(index){ 
					var paymentuser = $(this).val();
					selecteduser.push(paymentuser);
				});
				if(selecteduser.length == 0){
					alert('Please Select Users To Make Payment');
				}else{
					var month = $('#payment_month').val(); 
					var _token = $('#_token').val(); 
					$.ajax({
						url: '/admin/payment/make_contributor_payment',
						type: 'POST',
						data: {'_token':_token, 'month':month, 'id':selecteduser},
						success: function(data) {}
					});
				}
			})
			
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
