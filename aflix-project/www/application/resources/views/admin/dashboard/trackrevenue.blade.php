@extends('admin.master')

@section('content')


	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-12">
				<h3><i class="">$</i> Track Revenue</h3>
			</div>
		</div>
		<hr>
		<div class="panel panel-default">
            <div class="panel-heading"><h4>Set Filter Value To Filter Data</h4></div>
            <div class="panel-body">
				<div class="form-group row">		
					<div class="col-md-12">
						<form method="get" role="form" class="search-form-full">
							<div class="col-md-5">
								<div class="" >
									<label for="usr">Month:</label>
									<select class="form-control" name="month">
									    <option value="" >Select Month</option>
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
								</div>
							</div>
							<div class="col-md-5">
								<div class="" >
								 <label for="usr">Contributor:</label>
									<select class="form-control" id="user_id" name="contributor">
										<option value="">Select Contributor</option>
										<?php
										if(Auth::user()->contribute == 'contribute') {
											$uploaded = DB::select("select * from users where contribute='contribute' and id='".Auth::user()->id."'");
										}else {
											$uploaded = DB::select("select * from users where contribute='contribute'");
											}
										foreach($uploaded as $upload)
										{
										?>
										<option value="<?php echo $upload->id;?>" <?php if(@$contributor==$upload->id){ echo "Selected"; }?>><?php echo $upload->username;?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
							 <label for="usr"></label>
								<div class="" >
									<button type="submit" class="btn btn-default" role="button">Search</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
    </div>
	<div class="clear"></div>
<hr>
	<div class="gallery-env">

		<div class="row">
			<div class="col-md-4">
			    <div class="tile-stats tile-aqua">
				    <div class="icon"><i class="entypo-user"></i></div>
				    <div class="num" data-start="0" data-end="<?php echo $free_registered_users;?>" data-postfix="" data-duration="1500" data-delay="1200"><?php echo $free_registered_users;?></div>
				    <h3>Free Registered User</h3>
			    </div>
			</div><!-- column 1-->
			<div class="col-md-4">
			    <div class="tile-stats tile-aqua">
				    <div class="icon"><i class="entypo-user"></i></div>
				    <div class="num" data-start="0" data-end="<?php echo $monthly_paid_subscribed_users;?>" data-postfix="" data-duration="1500" data-delay="1200"><?php echo $monthly_paid_subscribed_users;?></div>
				    <h3>Month Subscribed User</h3>
			    </div>
			</div><!-- column 2-->
			<div class="col-md-4">
			    <div class="tile-stats tile-aqua">
				    <div class="icon"><i class="entypo-user"></i></div>
				    <div class="num" data-start="0" data-end="<?php echo $yearly_paid_subscribed_users;?>" data-postfix="" data-duration="1500" data-delay="1200"><?php echo $yearly_paid_subscribed_users;?></div>
				    <h3>Year Subscribed User</h3>
			    </div>
			</div><!-- column 3-->

		</div>

	</div>
<div class="clear"></div>
<hr>
 <table class="table table-striped" id="contributorviewrship">
    <thead>
		<tr class="table-header">
		    <th><input type="checkbox" id="select_all" name="select_all"></th>
			<th>Sr No.</th>
			<th>Video</th>
			<th>Category</th>
			<th>Contributor </th>
			<th>Video Type </th>
			<th>Revenue by Monthly Subscribers </th>
			<th>Revenue by Yearly Subscribers</th>
			<th>Total Revenue</th>
        </tr>
	</thead>
    <tbody>	
		<?php if(count($results) > 0){ 
		       $i = 1;
			  foreach($results as $result){
		   
		?>
			<tr class="content_<?php echo $result->id;?>">
			    <td><input type="checkbox" id="check_<?php echo $i;?>" class="usercheckbox" name="check_individual" value="<?php echo $result->id;?>"></td>
				<td><?php echo $i; ?></td>
				<td><?php echo $result->title ?></td>
				<td><?php echo $result->category ?></td>
				<td><?php echo $result->username ?></td>
				<td><?php echo ucwords($result->access) ?></td>
				<td><?php echo round($result->monthsubscriberevenue,2) ?></td>
				<td><?php echo round($result->yearsubscriberevenue,2) ?></td>
				<td><?php echo round($result->totalrevenue,2) ?></td>
			</tr>
		<?php $i++;}}else{ ?>	
            <tr colspan="9">
				<td><center>No Data To Display....</center></td>
			</tr>
		<?php } ?>	
		</tbody>		
	</table>
	@section('javascript')
	<script>
	$(document).ready(function() {
		$('#contributorviewrship').DataTable();
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
	});
		
	</script>



	@stop

@stop
