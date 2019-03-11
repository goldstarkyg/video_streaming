@extends('admin.master')

@section('content')
<?php
if(@$_GET['id']!='')
{
$sctive=DB::select("delete from banner where id='".@$_GET['id']."'");

}
?>
	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-thumb"></i>Manage Home Banner</h3><!--<a href="{{ URL::to('admin/user/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>-->
			</div>
			<div class="col-md-4">	
				<?php $search = request('s'); ?>
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" value="@if(!empty($search)){{ $search }}@endif" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>

     <form method="post" action="addbanner" enctype="multipart/form-data">
	<table class="table table-striped">
	<tr>	
	<td><p style="font-size: 16px; color:red;">Select Slider Image Min-(Width:1500px And Height:500px):</p>
	<br>
	<input type="file" name="file" class="form-control" required>
	<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
	<br>
	<p><b style="font-size: 16px; color: red;">Add Link</b></p>
	
	<input type="text" placeholder="Enter Link" name="add_link" class="form-control" >
	
	</td>
	
	</tr>	
	<tr>
	<td colspan=""><input type="submit" name="submit" class="btn btn-success" value="Submit"> &nbsp;&nbsp;&nbsp; <b style="float: right;margin-right: 973px;     margin-top: 4px;">New Window</b> <input type="checkbox" value="1" name="open"></td>
	</tr>
	</table>
   </form>

   <table class="table table-striped">
	<tr>
    <th>Slider Image</th>
	<th>Ads Link</th>
    <th>Action</th>	
	</tr>
	<?php
	$banners1 = DB :: select("select * from banner order by id desc");
		foreach($banners1 as $banner1)
		{ 
		?>
	<tr>
    <td><img src="/content/uploads/images/<?= $banner1->banner; ?>" style="width: 230px;"></td>
    <td><?php echo $banner1->add_link;?></td>
   <td><a href="?id=<?php echo $banner1->id;?>" class="btn btn-xs btn-danger delete1"><span class="fa fa-user"></span>Delete</a></td>	
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
				if (confirm("Are you sure you want to Delete Slider Image?")) {
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

