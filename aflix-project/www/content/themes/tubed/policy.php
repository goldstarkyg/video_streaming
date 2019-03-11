<?php include('includes/header.php'); ?>


	<h3 class="col-md-10 col-md-offset-2 right-content-10 header"><?php echo "Policy"; ?><?php if(isset($page_description)): ?><span><?= $page_description ?></span><?php endif; ?></h3>


<div class="col-md-offset-2 col-md-10 right-content-10">

		<div class="row">
		 <?php
		
		 @$videos = DB::select("select * from policy");
					foreach ($videos as $video) 
					{
					?>
         <div class="col-md-12 col-sm-12 col-xs-12 loop">
		
	  <?php echo $video->content; ?>
<br>
<br>
	</div>
			
<?php
}
?>
		</div>


	<?php //include('partials/pagination.php'); ?>

</div>


<?php include('includes/footer.php'); ?>