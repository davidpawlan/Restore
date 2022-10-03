<script>
base_url = "{{URL::to('/')}}";
var today = "{{date('m/d/Y')}}";
</script>
<input type="hidden" class="csrf_token" value="{{csrf_token()}}" />
<section class="header" id="myHeader">
  <nav class="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="{{URL::to('/')}}"><img src="{{URL::to('/')}}/public/images/logo_white.png"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{URL::to('/')}}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
        
        <li class="{{ (Request::is('reports') ? 'active' : '') }}"><a href="{{URL::to('/')}}/reports"><i class="fa fa-file-text-o" aria-hidden="true"></i> Report</a></li>
        
        <li class="{{ Request::is('analytics') ? 'active' : '' }}"><a href="{{URL::to('/')}}/analytics"><i class="fa fa-bar-chart" aria-hidden="true"></i> Analytics</a></li>
        
        <li class="{{ Request::is('settings') ? 'active' : '' }}"><a href="{{URL::to('/')}}/settings"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a></li>

        <li class="{{ Request::is('report-history') ? 'active' : '' }}"><a href="{{URL::to('/')}}/report-history"><i class="fa fa-clock-o" aria-hidden="true"></i>Report History</a></li>
      </ul>
   </div>
  <div class="profile_info">
    @php
      $userId = Auth::id();
      $getUserProfilePic = DB::table("schools")->where("user_id",$userId)->select("profile_image")->first();
      $profilePic = $getUserProfilePic->profile_image; 
    @endphp

          <ul>
            <Li>
            @if(empty($profilePic))
              <a href="{{URL::to('/')}}/settings"><p>@php echo substr(Auth::user()->name,0,1); @endphp</p></a>
               @else
              <a href="{{URL::to('/')}}/settings"><p><img style="width:30px;height:30px;border-radius:100%" class="img_header" src="{{URL::to('/')}}/public/uploads/profile_pic/{{$profilePic}}"></p></a>
                @endif

            </li>
            <li>
              <h5>
                @if(strlen(Auth::user()->name) > 10)
                  {{ substr(Auth::user()->name,0,10)}} ...
                @else
                  {{Auth::user()->name}}
                @endif
              </h5>

              <h6><a href="{{URL::to('/')}}/logout">Logout</a></h6></li>
          </ul>
        </div>
  </div>
</nav>
</section>