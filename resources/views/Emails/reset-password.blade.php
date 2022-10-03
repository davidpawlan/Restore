Hello {{$name}} ,
<p>You have requested to change your password</p>
<p>Click on the link below to reset your password</p>
<p><a href="{{URL::to('/')}}/reset-password/{{$token}}">Click here to reset password</a></p>