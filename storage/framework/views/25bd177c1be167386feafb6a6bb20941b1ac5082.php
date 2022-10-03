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
				<form method="POST" id="admin_login_form" action="<?php echo e(route('admin.login')); ?>" class="validate_me">
					<?php echo csrf_field(); ?>
					<div class="logo_form text-center">
						<img src="<?php echo e(URL::to('/')); ?>/public/images/logo.png">
						<p>LOG IN TO YOUR RESTORE ACCOUNT</p>
					</div>
					<div class="main_form">
						<?php if(Session::has('error')): ?>
							<p class="text-center"><label class="error"><?php echo e(Session::get('error')); ?></label></p>
						<?php endif; ?>
						
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" name="email" placeholder="Enter Email Address" class="form-control space_disallow" id="email" required="required" >
						</div>
						<div class="form-group">
							<label for="pwd">Password</label>
							<input type="password" style="display:none;"><!--Used to remove prefilled email and password-->
							<input type="password" name="password"  placeholder="Enter Password" class="form-control space_disallow" id="pwd" required="required" >
						</div>
						<div class="bottom_links">
						<ul>
							<li><a href="#"></a></li>
							<li class='btn_submit'><button type="submit">LOGIN</button></li>
						</ul>
					</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<!-- footer section start -->
<section class="footer">
	<p>&copy; Copyright <?php echo e(date("Y")); ?>. All Rights Reserved.</p>
</section>
<!-- footer section end -->

</body>
<script src="<?php echo e(URL::to('/')); ?>/public/js/jquery.min.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/public/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/public/js/custom.js"></script>
</html>


<?php /**PATH /var/www/html/restorewebsitephp/resources/views/Admin/login.blade.php ENDPATH**/ ?>