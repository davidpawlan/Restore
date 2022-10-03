
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
					<img src="{{asset('public/images/logo.png')}}">
					<p>FORGOT PASSWORD?</p>
				</div>
	
				<form class="validate_me" action="{{URL::to('/')}}/forgot-password" method="POST">
					@csrf
						<div class="main_form">
							<div class="forgt_text text-center">
								<h6>Enter your email address and we’ll send you a link to reset your password.</h6>
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" name="email"  placeholder="Enter Email" class="form-control" id="email" autocomplete="off" required>
								@error('email')
							    	<label class="error">{{ $message }}</label>
								@enderror
								@if(Session::has('error'))
									<label class="error">{{ Session::get('error') }}</label>
								@endif
								@if(Session::has('success'))
									<label class="success">{{ Session::get('success') }}</label>
								@endif
							</div>
							<div class="bottom_links">
							<ul>
								<li><a href="{{route('login')}}">Back to Login</a></li>
								<li class="btn_submit"><button type="submit">Submit</button></li>
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


