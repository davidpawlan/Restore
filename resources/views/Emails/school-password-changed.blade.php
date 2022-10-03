Hello {{$data['principle_name']}} ,
<p>Your Password is changed by admin</p>
<p>Your new password is below</p> 
<p>Password: {{$data['school_password']}}</p>
<p><a href="{{URL::to('/')}}/login">Click here to login</a></p>