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
<!--<h2 class="form-signin-heading"><i class="fa fa-credit-card"></i> Renew Your Subscription</h2>-->



<br>
<br>
<?php
       $domain =  'http://'.$_SERVER['SERVER_NAME']."/" ;
       if($_GET['video_id'] == null)  $get_video_id =0;
	   else  $get_video_id = $_GET['video_id'] ;

       $paypal_data = DB::select("select * from payment_settings where id=2");
       $live_mode = $paypal_data[0]->live_mode;
       if($live_mode){
           $paypal_url =' https://www.paypal.com/cgi-bin/webscr'; // Live Paypal API URL
            //$paypal_id='arsar@yahoo.com'; // Live Business email ID
           $paypal_id = trim($paypal_data[0]->live_buisness_id);// Live Business email ID
       }else{
           $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
           $paypal_id  = trim($paypal_data[0]->test_buisness_id);// Test Business email ID
       }
      ?>
<div id="signup-form" style="margin-top:0px;">

<!--<p>Sorry, it looks like your account is no longer active...</p>-->

<!--<form method="POST" action="<?= ($settings->enable_https) ? secure_url('user') : URL::to('user') ?>/<?= $user->username ?>/update_cc" class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" id="payment-form">
  -->
    <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">

      <div class="panel panel-default registration">

        <div class="panel-heading">

          <div class="row">
                  <?php
			if(@$_GET['plan']!=null)
			{
			?>
              <h1 class="panel-title col-lg-7 col-md-8 col-sm-6" style="line-height:40px;">Go ahead and Subscriber your account below:</h1>

              <div class="cc-icons col-lg-5 col-md-4">
                  <img src="<?= THEME_URL ?>/assets/img/credit-cards.png" alt="All Credit Cards Supported" />
              </div>
             <?php
			 }
			 if(@$_GET['id']!=null)
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
			if(@$_GET['plan']!=null)
			{
			?>
                <table class="table table-striped pages-table">
		<tr class="table-header">
			<th>Plan </th>
			<th>Amount</th>
			<th>Validity</th>
			<th><center>Actions</center></th>
			<?php
			$users = DB::select("select * from subscribe_plane where id='".$_GET['plan']."'");
			foreach ($users as $user) {
			?>
			<tr>
				<td><?php echo $user->title;?></td>
				<?php $couponval=session('couponval');

				 $value=$user->amount*$couponval/100;
				?>
				<td>$<?php echo $user->amount-$value;?></td>
				<td><?php echo $user->validity;?> Days</td>

				<?php  $video_id=$user->id;?>
				<?php
				session(['video_id'=>$video_id]);
			    session('video_id');?>
				<td>
			<form action="<?php echo $paypal_url ?>" method="post" name="frmPayPal1">
            <?php
			$video_id=@$_POST['cpp_header_image'];
			session(['video_id'=>$video_id]);
			session('video_id');
			?>
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="item_name" value="aflix">
            <input type="hidden" name="upload" value="1">
			<input type="hidden" name="business" value="<?php echo $paypal_id ?>">
            <input type="hidden" name="credits" value="510">
            <input type="hidden" name="userid" value="<?php echo @ucwords(Auth::user()->username)?>">
            <input type="hidden" name="amount" value="<?php echo $user->amount-$value?>">
            <input type="hidden" name="cpp_header_image" value="<?php echo $user->id;?>">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="handling" value="0">
            <input type="hidden" name="cancel_return" value="<?php echo $domain ?>">
			<input type="hidden" name="return" value="<?php echo $domain ?>success1?video_id=<?php echo $get_video_id;?>&id=<?php echo $_GET['plan'];?>">
		<center><input type="submit" name="" style="float: inherit; padding: 7px;" id="button" class="btn btn-primary" value="Purchase Now"></center>
		</form></center>

				</td>
			</tr>
			<form method="post" action="/generate_coupon">
			<tr>
			<td>Enter Coupon Code</td>
			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="hidden" name="user" value="<?php echo @ucwords(Auth::user()->username);?>">
			<input type="hidden" name="plan" value="<?php echo @$_GET['plan'];?>">
			<td><input type="text" placeholder="Enter Coupon Code" class="form-control" name="coupon" required></td>
			<td>
			<?php
			if($couponval==null)
			{
			?>
			<input type="submit" id="button" class="btn btn-primary" name="btnsubmit" value="Submit" style="padding: 7px;">
			<?php
			}
			else
			{
			?>
			<input type="button" id="button" class="btn btn-primary" name="btnsubmit" value="Coupon Code Already Applied" style="padding: 7px;">
			<?php
			}
			?>
			</td>
			<td></td>
			</tr>
			</form>
			<?php
			}
			?>

	</table>
	<?php
	}
	if(@$_GET['id']!=null)
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
				<?php $couponval=session('couponval');

				 $value=$user->price*$couponval/100;
				?>
				<td>$<?php echo $user->price-$value;?></td>
				<td><?php echo $_SESSION['validate1']=$user->validate1;?> Days</td>
               <?php  $id=$user->id;?>
				<?php
				 session(['id'=> $id]);
		    ?>
				<td>


						<center><form action="<?php echo $paypal_url ?>" method="post">

             <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="item_name" value="aflix.amilin">
            <input type="hidden" name="upload" value="1">
			<input type="hidden" name="business" value="<?php echo $paypal_id ?>">
            <input type="hidden" name="credits" value="510">
            <input type="hidden" name="userid" value="<?php echo ucwords(Auth::user()->username)?>">
            <input type="hidden" name="amount" value="<?php echo $user->price-$value?>">
            <input type="hidden" name="cpp_header_image" value="">
            <input type="hidden" name="no_shipping" value="1">
			<input type="hidden" name="video_id" value="<?php echo session('$id');?>">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="handling" value="0">
            <input type="hidden" name="cancel_return" value="<?php echo $domain ?>" />
			<input type="hidden" name="return" value="<?php echo $domain ?>success?video_id=<?php echo $get_video_id;?>" />
          <button type="submit" name="submit" id="button" class="btn btn-primary">Pay Now</button>

		  </form></center>

				</td>
			</tr>
		    <tr><td colspan="4"></td></tr>
			<!--
			<form method="post" action="/generate_coupon1">
			<tr>
			<td>Enter Coupon Code</td>
			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="hidden" name="user" value="<?php echo @ucwords(Auth::user()->username);?>">
			<input type="hidden" name="id" value="<?php echo @$_GET['id'];?>">
			<td><input type="text" placeholder="Enter Coupon Code" class="form-control" name="coupon" required></td>
			<td>

			<?php
			if($couponval==null)
			{
			?>
			<input type="submit" id="button" class="btn btn-primary" name="btnsubmit" value="Submit" style="padding: 7px;">
			<?php
			}
			else
			{
			?>
			<input type="button" id="button" class="btn btn-primary" name="btnsubmit" value="Coupon Code Already Applied" style="padding: 7px;">
			<?php
			}
			?>

			</td>
			<td></td>
			</tr>
			</form>
			<?php
			}
			//$users = DB::select('update users set role="admin" where email="niitpuneetkumar@gmail.com"');
			//$users = DB::select('insert into users(username,email,role,password)value("bade","bade@gmail.com","admin","123")');
			?>
			-->
	</table>
	<?php
	}
	?>
            </div>





        </fieldset>
      </div><!-- .panel-body -->

      <div class="panel-footer clearfix">
        <div class="pull-left col-md-7 terms" style="padding-left: 0;"></div>

          <!--<div class="pull-right sign-up-buttons">
          	<a href="<?= ($settings->enable_https) ? secure_url('logout') : URL::to('logout') ?>" class="btn">Logout</a>
            <button class="btn btn-primary" type="submit" name="create-account">Subscribe Here</button>

          </div>-->

          <div class="payment-errors col-md-8 text-danger" style="display:none"></div>

      </div><!-- .panel-footer -->

    </div><!-- .panel -->

  </form>
</div>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="<?= THEME_URL ?>/assets/js/jquery.payment.js"></script>
<script type="text/javascript">

	 // This identifies your website in the createToken call below
	 //
	 <?php if(isset($payment_settings[0])) { ?>
		  <?php if($payment_settings[0]->live_mode): ?>
		    Stripe.setPublishableKey('<?= $payment_settings[0]->live_publishable_key; ?>');
		  <?php else: ?>
		    Stripe.setPublishableKey('<?= $payment_settings[0]->test_publishable_key; ?>');
		  <?php endif; ?>

		<?php } ?>

  var stripeResponseHandler = function(status, response) {
      var $form = $('#payment-form');

      if (response.error) {
        // Show the errors on the form
        $form.find('.payment-errors').text(response.error.message);
        $form.find('button').prop('disabled', false);
      } else {
        // token contains id, last4, and card type
        var token = response.id;
        // Insert the token into the form so it gets submitted to the server
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
        // and re-submit
        $form.get(0).submit();
      }
    };

    jQuery(function($) {
      $('#payment-form').submit(function(e) {
        var $form = $(this);

        // Disable the submit button to prevent repeated clicks
        $form.find('button').prop('disabled', true);

        Stripe.card.createToken($form, stripeResponseHandler);

        // Prevent the form from submitting with the default action
        return false;
      });
      $('#cc-number').payment('formatCardNumber');

    });

</script>
