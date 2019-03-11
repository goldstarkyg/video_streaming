@extends('admin.master')

@section('content')
<?php
if(@$_GET['id']!='')
{
$sctive=DB::select("update thumnail_section set status=1 where id='".@$_GET['id']."'");

}
?>
<?php
if(@$_GET['id1']!='')
{
$sctive=DB::select("update thumnail_section set status=0 where id='".@$_GET['id1']."'");
}
?>
<?php
if(@$_GET['id2']!='')
{
$sctive=DB::select("update video_categories set status=1 where id='".@$_GET['id2']."'");

}
?>
<?php
if(@$_GET['id3']!='')
{
$sctive=DB::select("update video_categories set status=0 where id='".@$_GET['id3']."'");
}
?>
	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-thumb"></i>All Thumbnail Section</h3><!--<a href="{{ URL::to('admin/user/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New</a>-->
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
			<th>Section</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		<?PHP
		$section=DB::select("select * from thumnail_section");
		foreach($section as $sec)
		{
		?>
       <tr>
	   <td><?php echo $sec->name?></td>
	   <td><?php if($sec->status==1){?><div class="label label-success"><i class="fa fa-user"></i> Active Section</div><?php }else{?><a href="#" class="btn btn-xs btn-danger delete2"><span class="fa fa-user"></span> Block Section</a> <?php } ?></td>
	   <td><a href="" data-toggle="modal" data-target="#<?php echo $sec->id?>" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</a>
	  
	   <?php if($sec->status==0){?><a href="?id=<?php echo $sec->id;?>"><div class="label label-success"><i class="fa fa-user"></i> Active Section</div></a><?php }else{?><a href="?id1=<?php echo $sec->id;?>" class="btn btn-xs btn-danger delete1"><span class="fa fa-user"></span> Block Section</a> <?php } ?>
	   </td>
       </tr>

	   <!-- Modal -->
<div id="<?php echo $sec->id?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Section</h4>
      </div>
	  <form method="post" action="thumbsection">
      <div class="modal-body">
       <input type="text" name="section" class="form-control" value="<?php echo $sec->name?>">
	   <input type="hidden" name="id" value="<?php echo $sec->id?>">
	   <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
	   <br>
	   <input type="submit" name="btnupdate" class="btn btn-success pull-left" value="update">
      </div>
	  </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
	   
		<?php
		}
		?>	
		<?PHP
		$section=DB::select("select * from video_categories");
		foreach($section as $sec)
		{
		?>
       <tr>
	   <td><?php echo $sec->name?></td>
	   <td><?php if($sec->status==1){?><div class="label label-success"><i class="fa fa-user"></i> Active Section</div><?php }else{?><a href="#" class="btn btn-xs btn-danger delete2"><span class="fa fa-user"></span> Block Section</a> <?php } ?></td>
	   <td><a href="" data-toggle="modal" data-target="#<?php echo $sec->id?>" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</a>
	  
	   <?php if($sec->status==0){?><a href="?id2=<?php echo $sec->id;?>"><div class="label label-success"><i class="fa fa-user"></i> Active Section</div></a><?php }else{?><a href="?id3=<?php echo $sec->id;?>" class="btn btn-xs btn-danger delete1"><span class="fa fa-user"></span> Block Section</a> <?php } ?>
	   </td>
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
				if (confirm("Are you sure you want to Block this Section?")) {
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

