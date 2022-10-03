<!DOCTYPE html>
<html lang="en">
<head>
  <title>Restore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/style.css">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/custom.css">
</head>
<body>
<section class="outer_section">
	<div class="container">
		<div class="col-md-6 col-md-offset-3">
			<div class="inner_section">
				<div class="logo_form text-center">
					<img src="<?php echo e(URL::to('/')); ?>/public/images/logo.png">
					<p>LOG IN TO YOUR RESTORE ACCOUNT</p>
				</div>
				
					
					<div class="main_form">
						<?php if(Session::has('success')): ?>
							<p class="text-center"><label class="success"><?php echo e(Session::get('success')); ?></label></p>
						<?php endif; ?>
						<?php if(Session::has('error')): ?>
							<p class="text-center"><label class="error"><?php echo e(Session::get('error')); ?></label></p>
						<?php endif; ?>
						<form method="POST" action="<?php echo e(URL::to('/')); ?>/login" class="validate_me">
						<?php echo csrf_field(); ?>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" name="email" placeholder="Enter Email Address" class="form-control space_disallow" autocomplete="OFF" id="email" required>
						</div>
						<div class="form-group">
							<label for="pwd">Password</label>
							<input type="password" name="password"  placeholder="Enter Password" class="form-control space_disallow"  autocomplete="OFF" id="pwd" required>
						</div>
						<div class="bottom_links">
							<ul>
								<li><a href="<?php echo e(route('forgot-pasword')); ?>">Forgot Password?</a></li>
								<li class="btn_submit"><button type="submit">LOGIN</button></li>
							</ul>
						</div>
						</form>
					</div>
				
			</div>
		</div>
	</div>
</section>


<!-- footer section start -->
<section class="footer">
	<p>&copy; Copyright <?php echo e(date("Y")); ?>. All Rights Reserved.</p>
</section>
<!-- footer section end -->
<div style="clear: both;">
	<script src="<?php echo e(URL::to('/')); ?>/public/js/jquery.min.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/public/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/public/js/custom.js"></script>
</body>

</html>


<?php /**PATH /var/www/html/restore/resources/views/login.blade.php ENDPATH**/ ?>