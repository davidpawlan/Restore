<!DOCTYPE html>
<html lang="en">
<head>
  <title>Restore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="{{URL::to('/')}}/public/js/bootstrap.min.js"></script>
   <script src='{{URL::to('/')}}/public/js/bootstrap-slider.min.js'></script>
  <script src="{{URL::to('/')}}/public/js/highcharts.js"></script>
<script src="{{URL::to('/')}}/public/js/highcharts-more.js"></script>
 <script> 
  $(document).ready(function(){ 
    	$(".studnt_recrd ul li a").click(function(){
		  $(".right_upper").addClass("active");
		  $(".inner_studnt_listng").addClass("active");
		});

		$("span.bck_arror1").click(function(){
		  		
		  $(".right_upper").removeClass("active");
		   $(".inner_studnt_listng").remove("active");
		});
		
		
		$(".side_bar_tab ul li a").click(function(){
		  $(".left_abr_contnt").addClass("active");
		    $(".side_bar_tab").addClass("active");
		});

		$("span.bck_arror").click(function(){
		  $(".side_bar_tab").removeClass("active");
		   $(".left_abr_contnt").remove("active");
		});

		
		});
	</script>
    <style>
    .li_daily{
    	    border-top-right-radius: 0px !important;
		    border-bottom-right-radius: 0px !important;
		    border-right: 1px solid #162856;
    }
    .side_bar_tab ul.nav.nav-pills li a:hover,.nav-pills>li>a, .nav-pills>li{
	    background-color: #1d3267;
    }
    .nav>li>a:focus, .nav>li>a:hover {
		 background-color: #1d3267;
	} 

	nav li.active:hover{
		background-color: #4479ff !important;
	}
	.active_student{
		background-color: #eee;
	}
	</style>
</head>
<body>
<!--Include Header-->
@include("Elements.school_header")
<section class="inner_home">
<div class="mobile_view">
<div class="col-md-12">
	<div class="top_filter">
		<form action="">
				<div class="filter_input">
				<!-- <select class="select_schools hide">
					<option value="{{Auth::id()}}" selected>{{Auth::id()}}</option>
				</select> -->
				    <label>Grade</label>
					<select class="form-control" name="grade" onchange="this.form.submit()">
						<option value="">All Grades</option>
						@forelse($grades as $grade)
							<option @isset($_GET['grade']) @if($_GET['grade'] == $grade->id) SELECTED @endif @endisset value="{{$grade->id}}">{{$grade->name}}</option>
						@empty
						@endforelse
				    </select>
				</div>
				<div class="filter_input">
				<label>Student</label>
				<select class="form-control" name="student" onchange="this.form.submit()">
					<option value="">All Students</option>
					@forelse($students as $student)
						<option @isset($_GET['student']) @if(base64_decode($_GET['student']) == $student->id) SELECTED @endif @endisset value="{{base64_encode($student->id)}}">{{$student->name}}</option>
					@empty
					@endforelse
			    </select>
			</div>
		</form>
		</div>
		</div>
		<div class="col-md-12">
		  <div class="grade_listng right_upper">
	 
	  <h3>Grade: <span>1st grade </span></h3>
	  <div>
	  <div class="outer_garph">
	  <div class="grpah_1">
	  <h4>Restorative Practice</h4>
				<div id="container_1" style="height: 300px"></div>
				<ul class="grph_bar_line">
				<li><span>&nbsp;</span>SA- Self Awareness</li>
				<li><span>&nbsp;</span>SM- Self Management</li>
				<li><span>&nbsp;</span>RDM- Responsible Decision Making</li>
				<li><span>&nbsp;</span>RS- Relationship Skills</li>
				<li><span>&nbsp;</span>SA- Social Awareness </li>
				</ul>
				</div>
				
				<div class="grpah_1 bottm_grph">
	  <h4>Reports</h4>
	   <div class="daily_wekly">
		<ul>
			@php
			$urlQuery="";
			if(isset($_GET['grade']) && !empty($_GET['grade'])){
				$urlQuery .= "grade=".$_GET['grade'];
			}
			if(isset($_GET['student']) && !empty($_GET['student'])){
				$urlQuery .= "&student=".$_GET['student'];
			}
			@endphp

			<li  class="li_daily @if((!isset($_GET['filter'])) || (isset($_GET['filter']) && $_GET['filter'] == 'D'))active @endif  @if(!isset($_GET['filter']))active @endif"><a href="{{URL::to('/')}}?filter=D&{{$urlQuery}}">Daily</a></li>
			<li class="@if(isset($_GET['filter']) && $_GET['filter'] == 'W')active @endif"><a href="{{URL::to('/')}}?filter=W&{{$urlQuery}}">Weekly</a></li>
		</ul>
	  </div>
				  <div id="container1_2" style="height: 300px"></div>
				</div>
				
				  </div>
				  </div>
				
				</div>
		</div>
		</div>
	<div class="side_bar_tab">
		<h4>Grades</h4>
		<ul class="nav nav-pills">
		@forelse($grades as $grade)
				<li @isset($_GET['grade']) @if($_GET['grade'] == $grade->id) class="active" @endif @endisset><a href="{{URL::to('/')}}?grade={{$grade->id}}">{{ $grade->name}}</a></li>
		@empty
		@endforelse

	  </ul>
	  <div class="copyright_text">
		<p class="text-center">&copy; Copyright {{date("Y")}}. All Rights Reserved.</p>
	  </div>
	</div>
	<div class="left_abr_contnt">   
	  <div class="inner_studnt_listng">
				<div class="studnt_recrd">
					<h3><span class="bck_arror"><a href="#"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></span>@if(count($students) >1) Students @else Student @endif<span>({{count($students)}})</span></h3>
					<ul>
						@forelse($students as $student)
						<li  @isset($_GET['student'])  @if(base64_decode($_GET['student']) == $student->id) class="active_student" @endif @endisset  >
							<a href="{{URL::to('/')}}?student={{base64_encode($student->id)}}@isset($_GET['grade'])&grade={{$_GET['grade']}}@endisset"><div class="studnt_informtn">
								<h4>#{{$student->roll_number}}</h4>
								<h2>{{$student->name}}</h2>
								<h5>Gender: @if($student->gender == "M") Male @else Female @endif</h5>
							</div>
							<div class="studnt_nbame">
								<p>{{strtoupper(substr($student->name, 0, 2))}}</p>
							</div>
							<span class="tab_arrow"><Img src="{{URL::to('/')}}/public/images/tab_right_arrow.png"></span>
							</a>
						</li>
						@empty
						<li>No Student Found</li>
						@endforelse
						
						<!-- <li>
						<a href="#">
							<div class="studnt_informtn">
								<h4>#1901021</h4>
								<h2>Cally Mores</h2>
								<h5>Gender: Girl</h5>
							</div>
							<div class="studnt_nbame">
								<p>CM</p>
							</div>
							<span class="tab_arrow"><Img src="{{URL::to('/')}}/public/images/tab_right_arrow.png"></span>
						</a>
						</li> -->
						
						<!-- <Li>
						<a href="#">
							<div class="studnt_informtn">
								<h4>#1901021</h4>
								<h2>Aahron Shah</h2>
								<h5>Gender: Boy</h5>
							</div>
							<div class="studnt_nbame">
								<p>AS</p>
							</div>
							<span class="tab_arrow"><Img src="{{URL::to('/')}}/public/images/tab_right_arrow.png"></span>
							</a>
						</li> -->
						
						<!-- <Li>
						<a href="#">
							<div class="studnt_informtn">
								<h4>#1901021</h4>
								<h2>Baylee Sherlen</h2>
								<h5>Gender: Girl</h5>
							</div>
							<div class="studnt_nbame">
								<p>BS</p>
							</div>
						<span class="tab_arrow"><Img src="{{URL::to('/')}}/public/images/tab_right_arrow.png"></span>
							</a>
						</li> -->
						
						<!-- <Li>
						<a href="#">
							<div class="studnt_informtn">
								<h4>#1901021</h4>
								<h2>Abbie Thomas</h2>
								<h5>Gender: Girl</h5>
							</div>
							<div class="studnt_nbame">
								<p>AT</p>
							</div>
							<span class="tab_arrow"><Img src="{{URL::to('/')}}/public/images/tab_right_arrow.png"></span>
							</a>
						</li>
						
						<Li>
						<a href="#">
							<div class="studnt_informtn">
								<h4>#1901021</h4>
								<h2>Dainel Wick</h2>
								<h5>Gender: Boy</h5>
							</div>
							<div class="studnt_nbame">
								<p>DW</p>
							</div>
							<span class="tab_arrow"><Img src="{{URL::to('/')}}/public/images/tab_right_arrow.png"></span>
							</a>
						</li>
						 -->
						
					</ul>
				</div>
				
			</div>
	  
	  <div class="grade_listng right_upper">
	 @php
	 	$queryStringUrl ="";
	 	if(isset($_GET['grade']) && !empty($_GET['grade'])){
	 		$queryStringUrl .= "grade=".$_GET['grade'];
	 	}
	 	if(isset($_GET['student']) && !empty($_GET['student'])){
	 		$queryStringUrl .= "&student=".$_GET['student'];
	 	}
	 @endphp
	  <h3><span class="bck_arror1"><a href=""><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></span>@if(isset($gradeName) && !empty($gradeName)) Grade: <span> {{$gradeName->name}} </span> @else<span>&nbsp;</span> @endif<p><a href="{{URL::to('/')}}/reports?{{$queryStringUrl}}" style="text-decoration:underline">Add New Report</a></p></h3>
	  <div>
	  <div class="outer_garph">
	  <div class="grpah_1">
	  <h4>Restorative Practice</h4>
				<div id="container" style="height: 300px"></div>
				<ul class="grph_bar_line">
				<li><span>&nbsp;</span>SA- Self Awareness</li>
				<li><span>&nbsp;</span>SM- Self Management</li>
				<li><span>&nbsp;</span>RDM- Responsible Decision Making</li>
				<li><span>&nbsp;</span>RS- Relationship Skills</li>
				<li><span>&nbsp;</span>SA- Social Awareness </li>
				</ul>
				</div>
				
		<div class="grpah_1 bottm_grph">
	  		<h4>Reports</h4>
			   <div class="daily_wekly">
				<ul>
					@php
						$urlQuery="";
						if(isset($_GET['grade']) && !empty($_GET['grade'])){
							$urlQuery .= "grade=".$_GET['grade'];
						}
						if(isset($_GET['student']) && !empty($_GET['student'])){
							$urlQuery .= "&student=".$_GET['student'];
						}
					@endphp 
					<li  class="li_daily @if((!isset($_GET['filter'])) || (isset($_GET['filter']) && $_GET['filter'] == 'D'))active @endif"><a href="{{URL::to('/')}}?filter=D&{{$urlQuery}}">Daily</a></li>
					<li class="@if(isset($_GET['filter']) && $_GET['filter'] == 'W')active @endif"><a href="{{URL::to('/')}}?filter=W&{{$urlQuery}}">Weekly</a></li>
				</ul>
			  </div>
		      <div id="container1" style="height: 300px"></div>
  
				</div>
				
				  </div>
				  </div>
				  <div class="reports_not">
				  <div class="inner_rept_nt">
					<img src="{{URL::to('/')}}/public/images/no_yet.png">
					<h5>No report added yet.</h5>
					</div>
				  </div>
				</div>
				

	</div>
</section>
@php
$selfAwareness = 0; $selfManagement =0; $decisioMaking =0;$relationshipSkills=0;$socialAwareness=0;
if(isset($RestorativePractice['self_awareness'])){
	$selfAwareness = $RestorativePractice['self_awareness'];
}
if(isset($RestorativePractice['self_management'])){
	$selfManagement = $RestorativePractice['self_management'];
}
if(isset($RestorativePractice['responsible_decision_making'])){
	$decisioMaking = $RestorativePractice['responsible_decision_making'];
}
if(isset($RestorativePractice['relationship_skills'])){
	$relationshipSkills = $RestorativePractice['relationship_skills'];
}
if(isset($RestorativePractice['social_awareness'])){
	$socialAwareness = $RestorativePractice['social_awareness'];
}
@endphp
<script>
var chart = Highcharts.chart('container', {

  title: {
    text: ''
  },

  subtitle: {
    text: ''
  },
 tooltip: {
        yDecimals: 2
   },

  xAxis: {
    categories: ['SA', 'SM', 'RDM', 'RS', 'SA']
  },

  series: [{
  name: 'RP',
    type: 'column',
    colorByPoint: true,
	colors: "#805f85 #4c7fbe #76a229 #f9963c #31538c".split(" "),
    data: [{{$selfAwareness}}, {{$selfManagement}}, {{$decisioMaking}}, {{$relationshipSkills}}, {{$socialAwareness}}],
    showInLegend: false
  }]

});
</script>




<script>
var chart = Highcharts.chart('container_1', {

  title: {
    text: ''
  },

  subtitle: {
    text: ''
  },
 tooltip: {
        yDecimals: 2
   },

 xAxis: {
     categories: ['SA', 'SM', 'RDM', 'RS', 'SA']
	},

  series: [{
  name: 'RP',
    type: 'column',
    colorByPoint: true,
	colors: "#805f85 #4c7fbe #76a229 #f9963c #31538c".split(" "),
    data: [{{$selfAwareness}}, {{$selfManagement}}, {{$decisioMaking}}, {{$relationshipSkills}}, {{$socialAwareness}}],
    showInLegend: false
  }]

});
</script>

@php
$timePerios = "'" . implode ( "', '", array_map(function ($entry) {
  return $entry['time'];
}, $timeChart) ) . "'";

$timeReports =  implode(', ', array_map(function ($entry) {
  return $entry['reports'];
}, $timeChart));
@endphp
<script>
var chart = Highcharts.chart('container1_2', {

  title: {
    text: ''
  },

  subtitle: {
    text: ''
  },
 tooltip: {
        yDecimals: 2
   },

  xAxis: {
   /* categories:['12 AM', '1 AM', '2 AM', '3 AM', '4 AM', '5 AM', '6 AM', '7 AM', '8 AM', '9 AM', '10 AM','11 AM', '12 PM', '1 PM', '2 PM', '3 PM', '4 PM', '5 PM', '6 PM', '7 PM', '8 PM', '9 PM', '10 PM', '11 PM']*/
	categories:[{!! $timePerios !!}]
   },
   plotOptions: {
        column: {
            /* Here is the setting to limit the maximum column width. */
            maxPointWidth: 50
        }
    },
  series: [{
  name: 'Reports',
    type: 'column',
    colorByPoint: true,
	colors: "#4479ff #4479ff #4479ff #4479ff #4479ff".split(" "),
	data: [{{$timeReports}}],
	showInLegend: false
  }]

});
</script>

<script>
var chart = Highcharts.chart('container1', {

  title: {
    text: ''
  },

  subtitle: {
    text: ''
  },
 tooltip: {
        yDecimals: 2
   },

  xAxis: {
		categories:[{!! $timePerios !!}]
   },
   plotOptions: {
        column: {
            /* Here is the setting to limit the maximum column width. */
            maxPointWidth: 50
        }
    },
  series: [{
  name: 'Reports',
    type: 'column',
    colorByPoint: true,
	colors: "#4479ff #4479ff #4479ff #4479ff #4479ff".split(" "),
    /*data: [6, 12, 8, 14, 12, 8, 12, 10, 3, 8, 6, 12, 8, 14, 12, 8, 12, 10, 3, 8,12, 10, 3, 8],*/
	data: [{{$timeReports}}],

    showInLegend: false
  }]

});
</script>
 
</body>
</html>


