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
              <h1 class="panel-title col-lg-7 col-md-8 col-sm-6" style="line-height:40px; width:100%;">Thanks For Purchasing Premium Video:</h1>      			
          </div>

        </div><!-- .panel-heading -->

        <div class="panel-body">

            <!-- Credit Card Number -->
            <div class="form-group row">
			
                
			<center><img src="content/uploads/images/tick.png" style="width:108px;"></center>
			
			<?php
			$video_id=session('id');
			$users = DB::select('select * from videos where id='.$video_id.' ');
			foreach ($users as $user) {
				@$p=Auth::user()->email;
				@$p;
				@$aadmin=Auth::user()->role;
				$price=$user->price;
				$validate=$user->validate1;
				$a=$video_id;
				$date=date('Y-m-d');
				$enddate=date('Y-m-d',date(strtotime("+ $validate day", strtotime("$date"))));
			?>
			
				<h3 style="margin-bottom:0px; margin-top:7px; padding-bottom: 10px; font-size: 20px;">Video Title : <?php echo $user->title;?></h3>
				<h3 style="margin-bottom:0px; margin-top:7px; padding-bottom: 10px; font-size: 20px;">Video Price : $<?php echo $user->price;?></h3>
				<h3 style="margin-bottom:0px; margin-top:7px; padding-bottom: 10px; font-size: 20px;">Video Validity : <?php echo $user->validate1;?> Days</h3>
				<h3 style="margin-bottom:0px; margin-top:7px; padding-bottom: 10px; font-size: 20px;">End Video Validity on : <?php echo $enddate;?></h3>
				
			
			<?php
				if(@$p!="" AND @$aadmin!="admin")
				{
					@$id="";
					@$status="";
					$usersch = DB::select("select * from premium_video where userid='$p' AND video_id='$a'");
						foreach($usersch as $userch)
						{
						 @$userch->video_id;
								 if(@$id=="")
								 {
									@$id=$userch->video_id;
								 } else {
									@$id=$userch->video_id;
								 }

								 @$userch->status;
								 if(@$status=="")
								 {
									@$status=$userch->video_type;
								 } else {
									@$status=$userch->video_type;
								 }
						}
					if(@$id==@$video_id AND @$status=="premium")
					{

					}else{
						$users = DB::select("insert into premium_video(user_id,userid,video_id,video_price,validity,creat_date,end_date)value('".$user->user_id."','$p','$a','$price','$validate','$date','$enddate')");
					}
				}
			}
			//Session::unset('couponval');
			Session::forget('couponval');
			?>
            </div>
        </fieldset>
      </div><!-- .panel-body -->

      <div class="panel-footer clearfix">
        <div class="pull-left col-md-7 terms" style="padding-left: 0;"></div>
      
          <div class="pull-right sign-up-buttons">
          	  <?php $title=strtolower($user->title);
			   $string = str_replace(' ','-', $title);
			  ?>
			  
            <a href="/video/<?php echo $video_id."/".$string;?>"><button class="btn btn-primary" type="button" name="create-account">Go To Video</button></a>
            
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