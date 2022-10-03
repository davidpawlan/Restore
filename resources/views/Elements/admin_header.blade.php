<script>
base_url = "{{URL::to('/')}}";
var today = "{{date('m/d/Y')}}";
</script>
<input type="hidden" class="csrf_token" value="{{csrf_token()}}" />
<section class="header">
	<nav class="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="{{URL::to('/')}}/admin/analytics"><img src="{{URL::to('/')}}/public/images/logo_white.png"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="{{ Request::is('admin/analytics') ? 'active' : '' }}"><a href="{{URL::to('/')}}/admin/analytics"><i class="fa fa-bar-chart" aria-hidden="true"></i> Analytics</a></li>
        <li class="{{ Request::is('admin/schools') ? 'active' : '' }}"><a href="{{URL::to('/')}}/admin/schools"><i class="fa fa-university" aria-hidden="true"></i>  Schools Management</a></li>
        <li class="{{ Request::is('admin/report-history') ? 'active' : '' }}"><a href="{{URL::to('/')}}/admin/report-history"><i class="fa fa-clock-o" aria-hidden="true"></i>Report History</a></li>
      </ul>
  </div>
	<div class="profile_info">
    @php
      $profilePic = Auth::guard("admin")->user()->profile_pic; 
    @endphp
					<ul>
             @if(empty($profilePic))
						  <Li><a href="{{URL::to('/')}}/admin/settings"><p>@php echo substr(Auth::guard("admin")->user()->name,0,1); @endphp</p></a></li>
						 @else
              <Li><a href="{{URL::to('/')}}/admin/settings"><p><img style="width:30px;height:30px;border-radius:100%" class="img_header" src="{{URL::to('/')}}/public/uploads/profile_pic/{{$profilePic}}"></p></a></li>
             @endif
            <li><h5>{{Auth::guard("admin")->user()->name}}</h5><h6><a href="{{URL::to('/')}}/admin/logout">Logout</a></h6></li>
					</ul>
				</div>
  </div>
</nav>
</section>