<?php include('includes/header.php'); ?>

	<?php 
	@$type="contribute";
	if(@$type == 'contribute'): ?>

		<h3 class="col-md-10 col-md-offset-2 right-content-10 header">Contributer Registration </h3>

		<div class="col-md-10 col-md-offset-2 right-content-10">

			<form method="post" action="<?= URL::to('contributecreate') ?>" class="form-signin">
			<input type="text" class="form-control" placeholder="Full Name" tabindex="0" id="name" name="name" value="" required>
			    
			    <input type="email" class="form-control" placeholder="Email address " tabindex="0" id="email" name="email" value="" required>
			    
				<input type="Password" class="form-control" placeholder="Password" id="password" name="password" value="" required>
			    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
			    <br />
			    <input type="hidden" id="redirect" name="redirect" value="<?= Input::get('redirect') ?>" />
			    
				<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			</form>
		</div>

	<?php elseif(@$type == 'signup'): ?>

		<?php include('partials/signup.php'); ?>

	<!-- SHOW FORGOT PASSWORD FORM -->
	<?php elseif(@$type == 'forgot_password'): ?>

		<?php include('partials/form-forgot-password.php'); ?>

	<!-- SHOW RESET PASSWORD FORM -->
	<?php elseif(@$type == 'reset_password'): ?>

		<?php include('partials/form-reset-password.php'); ?>

	<?php endif; ?>

<?php include('includes/footer.php'); ?>