<style>
/* 
Max width before this PARTICULAR table gets nasty
This query will take effect for any screen smaller than 760px
and also iPads specifically.
*/
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	/*
	Label the data
	*/
	
}
</style>
<?php include('includes/header.php'); ?>
<br>
<br>
<div class="col-md-10 col-md-offset-2 right-content-10 user">
<div id="signup-form" style="margin-top:0px;">

<!--<p>Sorry, it looks like your account is no longer active...</p>-->

<form  action="signup" class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" id="payment-form">
    
    <input name="_token" type="hidden" value="">
      
      <div class="panel panel-default registration">
        
        <div class="panel-heading">
          
          <div class="row">
                  <?php
			if(@$_GET['id']==null)
			{
			?>
              <h1 class="panel-title col-lg-7 col-md-8 col-sm-6" style="line-height:40px;">Go ahead and Subscriber your account below:</h1>

              <div class="cc-icons col-lg-5 col-md-4">
                  <img src="<?= THEME_URL ?>/assets/img/credit-cards.png" alt="All Credit Cards Supported" />
              </div>
             <?php
			 }
			 else
			 {
			 ?>
			 <h1 class="panel-title col-lg-7 col-md-8 col-sm-6" style="line-height:40px;">Premium Video:</h1>

              <div class="cc-icons col-lg-5 col-md-4">
                  <img src="<?= THEME_URL ?>/assets/img/credit-cards.png" alt="All Credit Cards Supported" />
              </div>
			 <?php
			 }
			 ?>
          </div>

        </div><!-- .panel-heading -->

        <div class="panel-body">

            <!-- Credit Card Number -->
            <div class="form-group row">
			<?php
			if(@$_GET['id']==null)
			{
			?>
                <table class="table table-striped pages-table">
		<tr class="table-header">
			<th>Plan </th>
			<th>Amount</th>
			<th>Validity</th>
			<th><center>Actions</center></th>
			<?php
			$users = DB::select('select * from subscribe_plane ');
			foreach ($users as $user) {
			?>
			<tr>
				<td><?php echo $user->title;?></td>
				<td>$<?php echo $user->amount;?></td>
				<td><?php echo $user->validity;?> Days</td>
				
				<td>
					<?php
					@$p4=Auth::user()->email;
			if(@$p4==null)
			{
			?>
					
						<center><a href="" data-toggle="modal" data-target="#mylogin" class="btn btn-xs btn-info">Subscribe Here</a></center>
			<?php
			}
			else
			{	
			?>	
			<center><a href="<?php  echo '/user/' . @ucwords(Auth::user()->username) . '/renew_subscription?plan='.$user->id.'';?>" style="float: inherit; padding: 7px;" id="button" class="btn btn-xs btn-info">Subscribe Here</a></center>
                            
			<?php
			}
			?>
				</td>
			</tr>
			<?php
			}
			//$users = DB::select('update users set role="admin" where email="niitpuneetkumar@gmail.com"');
			//$users = DB::select('insert into users(username,email,role,password)value("bade","bade@gmail.com","admin","123")');
			?>
			
	</table>
	<?php
	}
	else
	{
	?>
	<table class="table table-striped pages-table">
		<tr class="table-header">
			<th>Video </th>
			<th>Amount</th>
			<th>Validity</th>
			<th><center>Actions</center></th>
			<?php
			$users = DB::select('select * from videos where id='.$_GET['id'].' ');
			foreach ($users as $user) {
			?>
			<tr>
				<td><?php echo $user->title;?></td>
				<td>$<?php echo $user->price;?></td>
				<td><?php echo $user->validate1;?> Days</td>
				
				<td>
					
					
						<center><a href="/login" class="btn btn-xs btn-info">Pay Now</a></center>
						
				</td>
			</tr>
			<?php
			}
			//$users = DB::select('update users set role="admin" where email="niitpuneetkumar@gmail.com"');
			//$users = DB::select('insert into users(username,email,role,password)value("bade","bade@gmail.com","admin","123")');
			?>
			
	</table>
	<?php
	}
	?>
            </div>


           

            
        </fieldset>
      </div><!-- .panel-body -->

      <div class="panel-footer clearfix">
        <div class="pull-left col-md-7 terms" style="padding-left: 0;"></div>
      
          <div class="pull-right sign-up-buttons">
          	<!--<a href="<?= ($settings->enable_https) ? secure_url('logout') : URL::to('logout') ?>" class="btn">Logout</a>
            <button class="btn btn-primary" type="submit" name="create-account">Registration Here</button>-->
            
          </div>

          <div class="payment-errors col-md-8 text-danger" style="display:none"></div>
  
      </div><!-- .panel-footer -->

    </div><!-- .panel -->
  
  </form>
</div>

</div>
<?php include('includes/footer.php'); ?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="<?= THEME_URL ?>/assets/js/jquery.payment.js"></script>
<script type="text/javascript">

<?php include('includes/footer.php'); ?>