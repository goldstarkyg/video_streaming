<?php include('includes/header.php'); ?>
<?php


      //$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
	 
	  //echo $_SESSION['video_id']=$_POST['video_id'];
	  //echo "<script>alert('".$_SESSION['video_id']."')</script>";
	  
	   //$paypal_url='https://www.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
	  
      //$paypal_id='shayam@gmail.com'; // Business email ID
      ?>
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
              <h1 class="panel-title col-lg-7 col-md-8 col-sm-6" style="line-height:40px; width:100%;">Thanks For Subscribe Membership Plan:</h1>                 

              
            
			
          </div>

        </div><!-- .panel-heading -->

        <div class="panel-body">

            <!-- Credit Card Number -->
            <div class="form-group row">
			
                
			<center><img src="content/uploads/images/tick.png" style="width:108px;"></center>

			<?php
            $domain =  'http://'.$_SERVER['SERVER_NAME']."/" ;
            $get_video_id = $_GET['video_id'];
            $video = DB::select('select * from videos where id='.$get_video_id.' ');
            $video_title =  strtolower(str_replace(' ','-', $video[0]->title));
			$video_id=$_GET['id'];
			$users = DB::select('select * from subscribe_plane where id='.$_GET['id'].' ');
			foreach ($users as $user) {
			@$p=Auth::user()->email;
							 @$p;
							$price=$user->amount; 
							$validate=$user->validity;
							$a=$video_id;
							$date=date('Y-m-d');
							 $enddate=date('Y-m-d',date(strtotime("+ $validate day", strtotime("$date"))));
			?>
			
				<h3 style="margin-bottom:0px; margin-top:7px; padding-bottom: 10px; font-size: 20px;">Membership Plan : <?php echo $user->title;?></h3>
				<h3 style="margin-bottom:0px; margin-top:7px; padding-bottom: 10px; font-size: 20px;">Membership Price : $<?php echo $user->amount;?></h3>
				<h3 style="margin-bottom:0px; margin-top:7px; padding-bottom: 10px; font-size: 20px;">Membership Validity : <?php echo $user->validity;?> Days</h3>
				<h3 style="margin-bottom:0px; margin-top:7px; padding-bottom: 10px; font-size: 20px;">End Membership Validity on : <?php echo $enddate;?></h3>
				
			
			<?php
            //$users = DB::select("update users set role='subscriber',plan='$video_id',plan_price='$price',start_plan='$date',end_plan='$enddate' where email='$p'");
			$users = DB::select("update users set role='subscriber', stripe_subscription='1',plan='$video_id',plan_price='$price',start_plan='$date',end_plan='$enddate' where email='$p'");
//            $user1 = Auth::user();
//            $subscription = DB::select("insert into subscriptions(user_id, name, stripe_id, stripe_plan, quantity, trial_ends_at,ends_at,created_at,updated_at) value('$user1->id','$user1->username', '$video_id', '$video_id', '$price','$enddate' , '$enddate','$date','$date')");
			}
			Session::forget('couponval');
			?>
			
	
	
            </div>


           

            
        </fieldset>
      </div><!-- .panel-body -->

      <div class="panel-footer clearfix">
        <div class="pull-left col-md-7 terms" style="padding-left: 0;"></div>
      
          <div class="pull-right sign-up-buttons">
              <a href="<?php echo $domain.'video/'.$get_video_id.'/'.$video_title?>"><button class="btn btn-primary" type="button" name="create-account">Go To Video</button></a>
            <a href="/"><button class="btn btn-primary" type="button" name="create-account">Go To Home</button></a>
            
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