Hello {{$data['principle_name']}} ,
<p>Your account is created in RESTORE</p>
<p>Bellow are your login credentials</p>
<p>Email: {{$data['school_email']}}</p>
<p>Password: {{$data['school_password']}}</p>
<p><a href="{{URL::to('/')}}/login">Click here to login</a></p>