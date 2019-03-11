@extends('admin.master')

@section('content')
<?php
if(@$_GET['id']!=null)
{
	$code = DB::select("delete from coupon_code where id='".@$_GET['id']."'");
	echo "<script>window.location='/admin/coupon'</script>";
}
?>
	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-newspaper"></i> Add Coupon Code</h3><a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal" ><i class="fa fa-plus-circle"></i> Add New</a>
				<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
	<form method="post" action="coupon/create_coupon">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Coupon Code</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped pages-table">
		<tr>
		<td><b>Coupon Name</b></td>
		<td><input type="text" name="name" class="form-control" style="border: 1px solid #9c9b9b;" required></td>
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		</tr>
		<tr>
		<td><b>Coupon Value</b></td>
		<td><input type="text" name="value" class="form-control" style="border: 1px solid #9c9b9b;" required></td>
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
			</div>
			<div class="col-md-4">	
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>


	<table class="table table-striped pages-table">
		<tr class="table-header">
			<th>Name</th>
			<th>Amount</th>
			
			<th>Actions</th>
			
			<?php
			$codes = DB :: select("select * from coupon_code ");
			foreach($codes as $code)
			{
			?>
			<tr>
				<td><?php echo $code->name;?></td>
				<td valign="bottom"><p><?php echo $code->value;?>%</p></td>
				<td>
					<p>
					
						<a href="" data-toggle="modal" data-target="#<?php echo $code->id?>" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</a>
						<a href="?id=<?php echo $code->id;?>" class="btn btn-xs btn-danger delete"><span class="fa fa-trash"></span> Delete</a>
					</p>
				</td>
			</tr>
				<!-- Modal -->
<div id="<?php echo $code->id?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
	<form method="post" action="coupon/edit_coupon">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Coupon Code</h4>
      </div>
	  <?php
			$codes1 = DB :: select("select * from coupon_code where id='".$code->id."'");
			foreach($codes1 as $code1)
			{
			?>
      <div class="modal-body">
        <b>Coupon Name</b>
		<br>
		<input type="text" name="name" value="<?php echo $code->name;?>" class="form-control" style="border: 1px solid #9c9b9b;">
		
		<input type="hidden" name="id" value="<?php echo $code->id;?>" class="form-control" style="border: 1px solid #9c9b9b;">
		<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
		
		<b>Coupon Value</b>
		<br>
		
		<input type="text" name="value" class="form-control" value="<?php echo $code->value;?>" style="border: 1px solid #9c9b9b;">
		<br>
		
		<center><input type="submit" name="submit" class="btn btn-success" value="Update"></center>
		
      </div>
	  <?php
			}
	  ?>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
</form>
  </div>
</div>
			<?php 
			}
			?>
	</table>

	<div class="clear"></div>

	<div class="pagination-outter"><?//= @$pages->@render(); ?></div>

	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this page?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>


@stop

