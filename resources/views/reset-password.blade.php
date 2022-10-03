
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
				<div class="logo_form text-center">
					<img src="{{URL::to('/')}}/public/images/logo.png">
					<p>RESET YOUR PASSWORD</p>
				</div>
				<form class="validate_me" method="POST" action="{{route('reset-password')}}" >
					@csrf
					<input type="hidden" name="reset-token" id="reset-token" value="{{$reset_token}}" />
						<div class="main_form">
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" minlength="5" placeholder="Enter New Password" class="form-control" name="new_password" id="password" required>
							</div>
							<div class="form-group">
								<label for="conf_pwd">Confirm Password</label>
								<input type="password"  placeholder="Enter Confirm Password" class="form-control" id="conf_pwd" equalTo="#password" required>
							</div>
							<div class="bottom_links">
							<ul>
								<li><a href="#"></a></li>
								<li class="btn_submit"><button type="submit">SUBMIT</button></li>
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


