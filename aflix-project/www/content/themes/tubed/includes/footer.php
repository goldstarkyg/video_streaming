<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-96551866-2', 'auto');
  ga('send', 'pageview');

</script>
<script type="text/javascript">
$.ajaxSetup({
   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
});
</script>
<!-- Modal -->
<div id="mylogin" class="modal fade" role="dialog">
    <div class="modal-dialog" style="">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #797b74;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"     style="color:#fff;">Login Below</h4>
            </div>
            <div class="modal-body" >
            <div id="l_err" style="display:none;color:red">Invalid login, please try again.</div>
                <div style="width: 55%;float: left;margin: 0;">
                    <form method="post" action="<?= ($settings->enable_https) ? secure_url('login') : URL::to('login') ?>">
                        <input type="text" class="form-control" placeholder="Email address" tabindex="0" id="email" name="email" value="<?php if($settings->demo_mode == 1): ?>demo<?php endif; ?>" required>
                        <br>
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?php if($settings->demo_mode == 1): ?>demo<?php endif; ?>" required>
                        <br>
                        <button class="btn btn-lg btn-primary btn-block" style="background-color: green;" type="submit">Sign in</button>

                        <?php
                        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        ?>

                        <input type="hidden" id="redirect" name="redirect" value="<?php  echo $actual_link; ?>" />
                        <a href="<?= ($settings->enable_https) ? secure_url('password/reset') : URL::to('password/reset') ?>">Forgot Password?</a>
                        <?php if($settings->demo_mode == 1): ?>
                            <div class="alert alert-info demo-info" role="alert">
                                <p class="title">Demo Login</p>
                                <p><strong>username:</strong> <span>demo</span></p>
                                <p><strong>password:</strong> <span>demo</span></p>
                            </div>
                        <?php endif; ?>
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
                    </form>
                </div>
                <div style="width: 40%;float: right;margin-top: 10px;">
                    <style>
                        .or-line1 {
                            background: #b7b7b7;
                            border-bottom: 1px solid #fff;
                            width: 2px;
                            float: left;
                            position: relative;
                            height: 243px;
                            text-align: center;
                        }
                        .or1{
                            position: absolute;
                            margin: 0 auto;
                            text-align: center;
                            top: 45.5%;
                            left: -16px;
                            font-size: 16px;
                            color: #747272;
                            background: #fff;
                            width: 34px;
                        }
                    </style>

                    <div class="or-line1">
                        <div class="or1">OR</div>
                    </div>
                    <div style="float: none;margin: 15% 0 0 25px;width: auto;">
                        <h4 style="margin: 0px;"><b>New User ?</b></h4><br>
                  <button type="button" id="myloginbtn" style="background-color: yellow;
    color: blue;
    font-weight: bold;
    border: solid 1px rgb(27, 0, 255);" class="btn btn-lg btn-primary btn-block" data-dismiss="modal" data-toggle="modal" data-target="#register">Sign Up Now</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 0px;">

            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="register" class="modal fade" role="dialog">
    <div class="modal-dialog" style="">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #797b74;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:#fff;">Enter your info below to signup for an account.</h4>
            </div>
            <div class="modal-body" style="height: 500px;
  overflow-y: auto;">
                <div class="panel-body" id="signup_form_div">
                    <!--<form method="POST" action="<?= ($settings->enable_https) ? secure_url('signup') : URL::to('signup') ?>" class="" id="payment-form" >-->
                    <form method="POST" class="" id="signup_form" onsubmit=" return submit_signup_frm()">
                        <input name="_token" id="signupformtoken" type="hidden" value="<?php echo csrf_token(); ?>">

                        <div class="col-md-12">
                            <fieldset>

                                <?php //$username_error = $errors->first('username'); ?>
                                <?php //if (!empty($errors) && !empty($username_error)): ?>
                                <!--<div class="alert alert-danger"><?//= $errors->first('username'); ?></div>-->
                                <?php //endif; ?>
                                <!-- Text input-->

								<div class="form-group row">
                                    <div class="col-md-6">

                                        <input type="text" class="form-control input-name" id="f_name" name="f_name" placeholder="First Name" value="<?= old('f_name'); ?>" required />
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control input-name" id="l_name" name="l_name" placeholder="Last Name" value="<?= old('l_name'); ?>" required>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">

                                        <input type="text" class="form-control input-cal" id="dob" placeholder="Birth Date" name="dob" required>

                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control input-message" id="email1" name="email" placeholder="Email Address" value="<?= old('email'); ?>" required onblur="email_check(this.value)">
										<span style="display:none;color:red" id="email_err">The email has already been taken.</span>

                                        <?php $email_error = $errors->first('email'); ?>
                                        <?php if (!empty($errors) && !empty($email_error)): ?>
                                            <div class="alert alert-danger"><?= $errors->first('email'); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- Text input-->
                                <div class="form-group row">
                                    <div class="col-md-6">
                                       <input type="password" class="form-control input-password" id="password1" placeholder="Password" name="password" required>
                                    </div>
                                    <?php $password_error = $errors->first('password'); ?>
                                    <?php if (!empty($errors) && !empty($password_error)): ?>
                                        <div class="alert alert-danger"><?= $errors->first('password'); ?></div>
                                    <?php endif; ?>
                                    <div class="col-md-6">
                                        <input type="password" class="form-control input-password" id="password_confirmation" placeholder="Re-Type Password" name="password_confirmation" required>
                                    </div>

                                    <?php $confirm_password_error = $errors->first('password_confirmation'); ?>
                                    <?php if (!empty($errors) && !empty($confirm_password_error)): ?>
                                        <div class="alert alert-danger"><?= $errors->first('password_confirmation'); ?></div>
                                    <?php endif; ?>
                                </div>
                                <!-- Text input-->
                                <!-- Text input-->


                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <select class="form-control input-cur" id="income" name="income" required>
                                            <option>Select Income</option>
                                            <option value="Below $1000">Below $1000</option>
                                            <option value="$1001-$3000">$1001-$3000</option>
                                            <option value="$3001-$5000">$3001-$5000</option>
                                            <option value="$5000 and above">$5000 and above</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control input-profession" id="profession" name="profession"  required>
                                            <option>Select Profession</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Executive">Executive</option>
                                            <option value="Clerk">Clerk</option>
                                            <option value="Business Owner">Business Owner</option>
                                            <option value="Government">Government</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 ">
                                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" class="form-control input-mob" id="mobile" name="mobile" placeholder="Mobile No" required />
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" class="form-control input-house-hold" id="nohouse" name="nohouse" placeholder="No of Household" required />
                                    </div>
                                </div>

                                <?php if(!$settings->free_registration): ?>
                                    <hr />

                                    <div class="payment-errors alert alert-danger"></div>

                                    <!-- Credit Card Number -->
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label">Credit Card Number</label>

                                        <div class="col-md-12">
                                            <input type="text" id="cc-number" class="form-control input-md cc-number" data-stripe="number" required="">
                                        </div>
                                    </div>


                                    <!-- Expiration Date -->
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label" for="cc-expiration-month">Expiration Date</label>

                                        <div class="col-md-3">
                                            <select class="form-control cc-expiration-month" data-stripe="exp-month" id="cc-expiration-month"><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>        </div>
                                        <div class="col-md-2">
                                            <select class="form-control cc-expiration-year" data-stripe="exp-year" id="cc-expiration-year"><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option></select>        </div>
                                    </div>


                                    <!-- CVV Number -->
                                    <div class="form-group row">
                                        <label class="col-md-4 control-label" for="cvv">CVV Number</label>

                                        <div class="col-md-3">
                                            <input id="cvv" type="text" placeholder="" class="form-control input-md cvc" data-stripe="cvc" required="">
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <center> <!--<button class="btn btn-primary" type="submit" name="create-account" id="submit_signup_form" style="background-color:orange; color:#fff;border: 0px;     margin: 10px auto;
    width: 45%; border: 2px solid #fcb44b;
    background: #fcb44b;
    color: #fff; padding:10px;" >SIGN UP </button>--->
	<a class="btn btn-primary" href="javascript:;" id="submit_signup_form"style="background-color:orange; color:#fff;border: 0px;     margin: 10px auto;
    width: 45%; border: 2px solid #fcb44b;
    background: #fcb44b;
    color: #fff; padding:10px;" >SIGN UP </a>
	</center>


                                <br>
                                <style>
                                    .or-line {
                                        background: #b7b7b7;
                                        border-bottom: 1px solid #fff;
                                        width: 100%;
                                        float: left;
                                        position: relative;
                                        height: 2px;
                                        text-align: center;
                                    }
                                    .or {
                                        position: absolute;
                                        margin: 0 auto;
                                        text-align: center;
                                        top: -8px;
                                        left: 45%;
                                        font-size: 16px;
                                        color: #747272;
                                        background: #fff;
                                        width: 50px;
                                    }
                                </style>
                                <div class="or-line">
                                    <div class="or">OR</div>
                                </div>
                                <br>

                                <div class="col-md-6">
                                    <h4 style="margin-top:0px; margin:0px; font-size: 18px; color:#555;">Already have an Account</h4>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal" id="registerbtn" data-target="#mylogin" style="float:right; border: 2px solid #52c39d; background-color:#52c39d; color:#fff;    width: 155px;">LOGIN</button>
                                </div>
                            </fieldset>
                            </div>
                    </form>
                </div>
                <div id="success_error_message" style="display:none;">
				</div>


            </div><!-- .panel-body -->
        </div>
        <!--<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>-->
    </div>

</div>
<!--- success/error mesasge model start---------------------->
<!-- Modal -->
<div id="success_error_message" class="modal fade" role="dialog">
    <div class="modal-dialog" style="">
        <!-- Modal content-->
        <div class="modal-content">
            <!--<div class="modal-header" style="background-color: #797b74;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:#fff;">Enter your info below to signup for an account.</h4>
            </div>-->
            <div class="modal-body" style="height: 100px; overflow-y: auto;">
                <div class="panel-body" id="">
                  
                </div>
            </div>
        </div>
       
    </div>

</div>
<!--- success/error mesasge model end---------------------->

</div>

<footer class="col-md-offset-2 col-md-10 right-content-10">

    <div class="col-md-4">
        <h3><?php echo $settings->website_name; ?></h3>
        <p><?= HelloVideo\Libraries\ThemeHelper::getThemeSetting(@$theme_settings->footer_description, 'HelloVideo is your Video Subscription Platform. Add unlimited videos, posts, and pages to your subscription site. Earn re-curring revenue and require users to subscribe to access premium content on your website.') ?></p>
        <a href="http://facebook.com/<?php echo $settings->facebook_page_id; ?>" target="_blank" class="facebook social-link"><i class="fa fa-facebook"></i></a>
        <a href="http://twitter.com/<?php echo $settings->twitter_page_id; ?>" target="_blank" class="twitter social-link"><i class="fa fa-twitter"></i></a>
        <a href="http://plus.google.com/<?php echo $settings->google_page_id; ?>" target="_blank" class="google social-link"><i class="fa fa-google-plus"></i></a>
        <a href="http://youtube.com/<?php echo $settings->youtube_page_id; ?>" target="_blank" class="youtube social-link"><i class="fa fa-youtube"></i></a>
        <div class="clear"></div>
    </div>
    <div class="col-md-4">
        <h3>Video Categories</h3>
        <ul>
            <?php foreach($video_categories as $category): ?>
                <li><a href="<?= ($settings->enable_https) ? secure_url('videos/category') : URL::to('videos/category'); ?><?= '/' . $category->slug; ?>"><?= $category->name; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!--<div class="col-md-3">
                    <h4>Post Categories</h3>
                    <ul>
                        <?php foreach($post_categories as $category): ?>
                            <li><a href="<?= ($settings->enable_https) ? secure_url('posts/category') : URL::to('posts/category'); ?><?= '/' . $category->slug; ?>"><?= $category->name; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>-->
    <div class="col-md-4">
        <h3>Links</h3>
        <ul>
            <?php foreach($pages as $page): ?>
                <!--<li><a href="<?= ($settings->enable_https) ? secure_url('page') : URL::to('page'); ?><?= '/' . $page->slug ?>"><?= $page->title ?></a></li>-->
            <?php endforeach; ?>
			<?php
			if(@Auth::user()->email==null)
			{
			?>
            <li><a href="" data-dismiss="modal" data-toggle="modal" data-target="#mylogin">Login</a></li>
            <li><a href="" data-dismiss="modal" data-toggle="modal" data-target="#register">Signup</a></li>
			<?php
			}
			?>
            <li><a href="/about">About Us</a></li>
            <li><a href="/policy">Policy</a></li>

            <!--<li><a href="/policy">Subscription Plan</a></li>-->

        </ul>
    </div>

    <div class="clear"></div>

    <hr />
    <p class="copyright">Copyright &copy; <?= date('Y'); ?> <?= $settings->website_name; ?></p>

</footer>

</div><!-- .col-md-10 -->

</div><!-- .row -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?= THEME_URL . '/assets/js/bootstrap-growl.min.js'; ?>"></script>
<script src="<?= THEME_URL . '/assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?= THEME_URL . '/assets/js/moment.min.js'; ?>"></script>
<script src="<?= THEME_URL . '/assets/js/main.js'; ?>"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">

    $('document').ready(function(){


		<?php if(session('note_type') != '' && session('note_type') == 'L_error'): ?>

		$("#mylogin").addClass('in');
		$("#mylogin").show();
		$('#l_err').css('display','block');

		<?php endif;?>


		$('button.close').click(function(){
			$("#mylogin").removeClass('in');
			$("#mylogin").hide();
			$('#l_err').css('display','none');
			});

		$( "#dob" ).datepicker({
      changeYear: true,
      yearRange: "1940:" + new Date('Y')
    });

        $('.dropdown').hover(function(){
            $(this).addClass('open');
        }, function(){
            $(this).removeClass('open');
        });

        <?php if(session('note') != '' && session('note_type') != ''): ?>

        <?php if(session('note_type') != '' && session('note_type') == 'error'): ?>
        $.growl({ icon: "fa fa-times-circle-o", message: ' <?= str_replace("'", "\\'", session("note")) ?>' }, { type: "danger" });
        <?php endif; ?>

        <?php if(session('note_type') != '' && session('note_type') == 'success'): ?>
        $.growl({ icon: "fa fa-check-circle-o", message: ' <?= str_replace("'", "\\'", session("note")) ?>' }, { type: "success" });
        <?php endif; ?>

        <?php if(session('note_type') != '' && session('note_type') == 'warning'): ?>
        $.growl({ icon: "fa fa-exclamation-triangle", message: ' <?= str_replace("'", "\\'", session("note")) ?>' }, { type: "warning" });
        <?php endif; ?>

        <?php Session::forget('note');
        Session::forget('note_type');
        ?>
        <?php endif; ?>

        $('#nav-toggle').click(function(){
            $(this).toggleClass('active');
            $('.navbar-collapse').toggle();
            $('body').toggleClass('nav-open');
        });

        $('#mobile-subnav').click(function(){
            if($('.second-nav .navbar-left').css('display') == 'block'){
                $('.second-nav .navbar-left').slideUp(function(){
                    $(this).addClass('not-visible');
                });
                $(this).html('<i class="fa fa-bars"></i> Open Submenu');
            } else {
                $('.second-nav .navbar-left').slideDown(function(){
                    $(this).removeClass('not-visible');
                });
                $(this).html('<i class="fa fa-close"></i> Close Submenu');
            }

        });

    });


    /********** LOGIN MODAL FUNCTIONALITY **********/

    var loginSignupModal = $('<div class="modal fade" id="loginSignupModal" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog" style="width:350px;"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="myModalLabel">Login Below</h4></div><div class="modal-body" style="margin-left: 10px;"></div></div></div></div>');



    /********** END LOGIN MODAL FUNCTIONALITY **********/


    /********** Signup MODAL FUNCTIONALITY **********/

    var SignupModal = $('<div class="modal fade" id="SignupModal" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="myModalLabel" style="background-color: #797b74;padding-bottom:10px; color:#fff;">Enter your info below to signup for an account.</h4></div><div class="modal-body" style="margin-left: 10px; margin-top: -30px"></div></div></div></div>');

    $(document).ready(function(){

        // Load the Modal Window for login signup when they are clicked
        $('.signup-desktop1 a').click(function(e){
            e.preventDefault();
            $('body').prepend(SignupModal);
            $('#SignupModal .modal-body').load($(this).attr('href') + '?redirect=' + document.URL + ' #signup-form', function(){
                $('#SignupModal').show(200, function(){
                    setTimeout(function() { $('#email').focus() }, 300);


                });
                $('#SignupModal').modal();

            });

            // Be sure to remove the modal from the DOM after it is closed
            $('#SignupModal').on('hidden.bs.modal', function (e) {
                $('#SignupModal').remove();
            });

        });
        $('#register .modal-header .close').click(function(){
			$('#success_error_message').hide();
			$('#register .modal-body').attr('style', 'height: 500px !important');
			$('#signup_form_div').show();
	    });
		
		$('#success_error_message').on('click', '.signup_form_close', function(){
			$('#success_error_message').hide();
			$('#register .modal-body').attr('style', 'height: 500px !important');
			$('#signup_form_div').show();
			//$('#register').remove();
			$("#register .close").click();
			
		})
        // submit signup form
			$('#submit_signup_form').click(function(){
				if(validate_frm()){
					$.ajax({
						url: '<?php echo URL::to('userregistration') ?>',
						type: 'POST',
						data: {'data':$('#signup_form').serialize(),'_token':$('#signupformtoken').val()},
						success: function(response) {
							$(':input','#signup_form')
								 .not(':button, :submit, :reset, :hidden')
								 .val('')
								 .removeAttr('checked')
								 .removeAttr('selected');
								$('#signup_form_div').hide();
							if(response == 'success'){
								$('#success_error_message').show();
								$('#register .modal-body').attr('style', 'height: 100px !important');
								var msg = '<div class="alert alert-success">'+
											   'Thank You for signing up.Please Login......'+
											   '<a href="" class="btn btn-primary signup_form_close" data-toggle="modal" data-target="#mylogin" ">'+
											   '<i class="fa fa-lock"></i> Login<span class="border-bottom"></span></a>'+
										   '</div>';
								$('#success_error_message').html(msg);
							}else{
								$('#success_error_message').show();
								$('#register .modal-body').attr('style', 'height: 100px !important');
								var msg = '<div class="alert alert-danger">'+
											   '<strong>Sorry!</strong> Your Account Could Not Be Created Pls. Try Again.'+
										   '</div>';
								$('#success_error_message').html(msg);
							}
						}
					});
				}	
			})
    });

    /********** END Signup MODAL FUNCTIONALITY **********/


</script>

<script>
	function validate_frm(){
		var f_name = $('#f_name').val();
		var l_name = $('#l_name').val();
		var dob    = $('#dob').val();
		var email1 = $('#email1').val();
		var income = $('#income').val();
		var profession = $('#profession').val();
		var mobile     = $('#mobile').val();
		var nohouse    = $('#nohouse').val();
		var c_pass=$('#password_confirmation').val();
		var pass=$('#password1').val();
		if(c_pass!=pass){
			$('#password_confirmation').val('');
			$('#password_confirmation').focus();
			return false;
		}
		if(f_name == ''){
			$('#f_name').focus();
			return false;
		}
		if(l_name == ''){
			$('#l_name').focus();
			return false;
		}
		if(dob == ''){
			$('#dob').focus();
			return false;
		}
		if(email1 == ''){
			$('#email1').focus();
			return false;
		}
		if(income == ''){
			$('#income').focus();
			return false;
		}
		if(profession == ''){
			$('#profession').focus();
			return false;
		}
		if(mobile == ''){
			$('#mobile').focus();
			return false;
		}
		if(nohouse == ''){
			$('#nohouse').focus();
			return false;
		}
		return true;
	}

	function email_check(email){
		if(email!=''){
			$.ajax({
				url:"<?php echo URL::to('check_email') ?>/"+email,
				type:'get',
				success:function(r){
					if(r==1){
						$('#email_err').css('display','block');
						$('#email1').val('');
						}else{
							$('#email_err').css('display','none');
						}
						setTimeout(function(){
							$('#email_err').css('display','none');
							},10000);
					}
				})
			}
	}

	/*function submit_signup_frm(){
		if(validate_frm()){
			$.ajax({
					url: '<?php echo URL::to('userregistration') ?>',
					type: 'POST',
					data: {'data':$('#signup_form').serialize(),'_token':$('#signupformtoken').val()},
					success: function(response) {
						$(':input','#signup_form')
							 .not(':button, :submit, :reset, :hidden')
							 .val('')
							 .removeAttr('checked')
							 .removeAttr('selected');
							$('#signup_form_div').hide();
						if(response == 'success'){
							$('#success_error_message').show();
							$('#register .modal-body').attr('style', 'height: 100px !important');
							var msg = '<div class="alert alert-success">'+
										   '<strong>Welcome!</strong> Your Account has been Successfully Created! .'+
									   '</div>';
							$('#success_error_message').html(msg);
						}else{
							$('#success_error_message').show();
							$('#register .modal-body').attr('style', 'height: 100px !important');
							var msg = '<div class="alert alert-danger">'+
										   '<strong>Sorry!</strong> Your Account Could Not Be Created Pls. Try Again.'+
									   '</div>';
							$('#success_error_message').html(msg);
						}
					}
				});
		
		}
	}*/
</script>

<?php if(isset($settings->google_tracking_id)): ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', '<?= $settings->google_tracking_id ?>', 'auto');
        ga('send', 'pageview');
    </script>
<?php endif; ?>

<script><?= HelloVideo\Libraries\ThemeHelper::getThemeSetting(@$theme_settings->custom_js, '') ?></script>

</body>
</html>
<style>
.input-name{background: url(<?=URL::to('application/public/icons')?>/user.png) no-repeat scroll 0px 3px;
padding-left:30px;
    padding-top: 8px;
    padding-bottom: 8px;
}
.input-cal{background: url(<?=URL::to('application/public/icons')?>/calendar.png) no-repeat scroll 0px 3px;
padding-left:30px;
    padding-top: 8px;
    padding-bottom: 8px;
}

.input-message{background: url(<?=URL::to('application/public/icons')?>/email.png) no-repeat scroll 0px 3px;
padding-left:30px;
    padding-top: 8px;
    padding-bottom: 8px;
}

.input-password{background: url(<?=URL::to('application/public/icons')?>/lock.png) no-repeat scroll 0px 3px;
padding-left:30px;
    padding-top: 8px;
    padding-bottom: 8px;
}

.input-cur{background: url(<?=URL::to('application/public/icons')?>/dolloar.png) no-repeat scroll 0px 3px;
padding-left:30px;
    padding-top: 8px;
    padding-bottom: 8px;
}

.input-profession{background: url(<?=URL::to('application/public/icons')?>/profession.png) no-repeat scroll 0px 3px;
padding-left:30px;
    padding-top: 8px;
    padding-bottom: 8px;
}


.input-mob{background: url(<?=URL::to('application/public/icons')?>/mobile.png) no-repeat scroll 0px 3px;
padding-left:30px;
    padding-top: 8px;
    padding-bottom: 8px;
}


.input-house-hold{background: url(<?=URL::to('application/public/icons')?>/house_hold.png) no-repeat scroll 0px 1px;
padding-left:34px;
    padding-top: 6px;
    padding-bottom: 15px;
}

</style>
