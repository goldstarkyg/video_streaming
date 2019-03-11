<?php include('includes/header.php'); ?>


	<h3 class="col-md-10 col-md-offset-2 right-content-10 header"><?php echo "About Us"; ?><?php if(isset($page_description)): ?><span><?= $page_description ?></span><?php endif; ?></h3>


<div class="col-md-offset-2 col-md-10 right-content-10">

		<div class="row">
		 <?php
		
		 @$videos = DB::select("select * from about ");
					foreach ($videos as $video) 
					{
					?>
         <div class="col-md-12 col-sm-12 col-xs-12 loop" style="color: #fff;">
		
	  <?php //echo $video->content; ?>
	  
	  <b style="font-size:20px;">ABOUT US</b> 
	  <br>
	  <br>
	  <b>Aflix </b>is the world 1st ethical entertainment streaming platform for children and family to enjoy entertainment within permissible Sharia friendly guideline. Aflix is a subscription video on demand platform that enables the user to either stream or download the content at a time and place of their convenience.  
	  <br>
	  <br>
	  <b style="font-size:20px;">VISION</b>
	  <br>
	  <br>
	  To become the best global ethical entertainment streaming platform & to helpcontent creator around the world
      <br>
	  <br>
	  <b style="font-size:20px;">OUR PRODUCTS </b>
	  <br>
	  <br>
	  Streaming media and video on demand 
	  <br>
	  <br>
	  <b style="font-size:20px;">OUR SERVICES</b>
	  <br>
	  <br>
	  Content production and distribution 
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