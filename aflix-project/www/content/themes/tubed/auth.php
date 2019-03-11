<?php include('includes/header.php'); ?>

	<?php if($type == 'login'): ?>

		<h3 class="col-md-10 col-md-offset-2 right-content-10 header">Please Login</h3>

		<div class="col-md-10 col-md-offset-2 right-content-10">

			<form method="post" action="<?= ($settings->enable_https) ? secure_url('login') : URL::to('login') ?>" class="form-signin">
			    <input type="text" required class="form-control" placeholder="Email address " tabindex="0" id="email" name="email" value="<?php if($settings->demo_mode == 1): ?>demo<?php endif; ?>">
			    <input type="password" required class="form-control" placeholder="Password" id="password" name="password" value="<?php if($settings->demo_mode == 1): ?>demo<?php endif; ?>">
			    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
				<br>
				 <center>OR</center>

				 <br>
                <button type="button" class="btn btn-lg btn-primary btn-block" data-toggle="modal" data-target="#register">Sign Up</button>

			    <br />


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

	<?php elseif($type == 'signup'): ?>

		<?php include('partials/signup.php'); ?>

	<!-- SHOW FORGOT PASSWORD FORM -->
	<?php elseif($type == 'forgot_password'): ?>


		<?php include('partials/form-forgot-password.php'); ?>

	<!-- SHOW RESET PASSWORD FORM -->
<?php elseif($type == 'reset_password'): ?>



		<?php include('partials/form-reset-password.php'); ?>

	<?php endif; ?>

<?php include('includes/footer.php'); ?>
