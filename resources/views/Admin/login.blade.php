<!DOCTYPE html>
<html lang="en">
<head>
  <title>Restore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/style.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/custom.css">
</head>
<body>
<section class="outer_section">
	<div class="container">
		<div class="col-md-6 col-md-offset-3">
			<div class="inner_section">
				<form method="POST" id="admin_login_form" action="{{ route('admin.login') }}" class="validate_me">
					@csrf
					<div class="logo_form text-center">
						<img src="{{URL::to('/')}}/public/images/logo.png">
						<p>LOG IN TO YOUR RESTORE ACCOUNT</p>
					</div>
					<div class="main_form">
						@if(Session::has('error'))
							<p class="text-center"><label class="error">{{ Session::get('error') }}</label></p>
						@endif
						
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
	<p>&copy; Copyright {{date("Y")}}. All Rights Reserved.</p>
</section>
<!-- footer section end -->

</body>
<script src="{{URL::to('/')}}/public/js/jquery.min.js"></script>
<script src="{{URL::to('/')}}/public/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="{{URL::to('/')}}/public/js/custom.js"></script>
</html>


