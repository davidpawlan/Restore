<!DOCTYPE html>
<html lang="en">
<head>
  <title>Restore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/style.css">
   <link rel="stylesheet" href="{{URL::to('/')}}/public/css/custom.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/highcharts.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet' href='{{URL::to("/")}}/public/css/bootstrap-datetimepicker.min.css'>

  <script src="{{URL::to('/')}}/public/js/jquery.min.js"></script>
  <script src="{{URL::to('/')}}/public/js/bootstrap.min.js"></script>
  <script src="{{URL::to('/')}}/public/js/highcharts.js"></script>
  <script src="{{URL::to('/')}}/public/js/highcharts-more.js"></script>
  <script src="{{URL::to('/')}}/public/js/draggable-points.js"></script>
  <script src="{{URL::to('/')}}/public/js/moment.min.js"></script>
  <script src="{{URL::to('/')}}/public/js/bootstrap-datetimepicker.min.js"></script>

  <style>
	#container .highcharts-color-1 {
		fill: #ce6ddd!important;
		stroke: #ce6ddd;
	}
	select option {
    	width:100%;
    	text-overflow:ellipsis;
    	overflow:hidden;
	}
	.filter_input input{
	    height: 52px
	}
	g.highcharts-data-labels.highcharts-series-0.highcharts-column-series.highcharts-tracker {
      display: none;
	}
	 g.highcharts-label.highcharts-data-label.highcharts-data-label-color-undefined {
      display: none;
	}
</style>
</head>

<body>
	<!--Include Header-->
	@include("Elements.admin_header")

<!---Data Makes for PDf starts-->
<!---Data for PDF header-->
<div class="pdfHeaderEport hide">
	<div class="SchoolInfo">
		School: 
		{{$pdfArray['school']}}
	</div>
	<div class="totalSchools">
		Total No. of Schools:
		{{$pdfArray['total_schools']}}
	</div>
	<div class="gradeInfo">
		Grade: 
		{{$pdfArray['grade']}}
	</div>

	@if($pdfArray['total_grade'] != 1)
	<div class="totalgrades">
		Total No. of Grades:
		{{$pdfArray['total_grade']}}
	</div>
	@endif
	<div class="studentInfo">
		Student: 
		{{$pdfArray['student']}}
	</div>
	@if($pdfArray['total_student'] != 1)
	<div class="totalStudents">
		 Total No. of Students:
		 {{$pdfArray['total_student']}}
	</div>
	@endif
	<div class="timePeriodInfo">
		 Time Period:
		 {{$pdfArray['time_period']}}
	</div>
	@php
		if(isset($_GET['duration']) && !empty(trim($_GET['duration']))){
           $timePeriod  = $_GET['duration'];
	    }else{	
	    	$timePeriod = "D";
		}
	@endphp

	@if($timePeriod == "C")
			<div class="timePeriodDetails">
				 From:  {{date("d M, Y",strtotime($pdfArray['start_date']))}} 
				 To: {{date("d M, Y",strtotime($pdfArray['end_date']))}}
			</div>
	    @elseif($timePeriod == "D")
		 	<div class="timePeriodDetails">
				 Date: {{date("d M, Y",strtotime($pdfArray['start_date']))}} 
			</div>
		@elseif($timePeriod == "W")
	 	<div class="timePeriodDetails">
				 From: {{date("d M, Y",strtotime($pdfArray['start_date']))}}
				 To: {{date("d M, Y",strtotime(date("Y-m-d")))}} 
		</div>
		@elseif($timePeriod == "M")
	 	<div class="timePeriodDetails">
				 Month: {{date("F",strtotime($pdfArray['start_date']))}}
		</div>
		@elseif($timePeriod == "Y")
	 	<div class="timePeriodDetails">
	 		@php
	 			$startFromYear = date("Y",strtotime($pdfArray['start_date']));
	 			if(date("Y") > $startFromYear){
	 			 $endYear = date("Y");
	 			}
	 		@endphp
				Year: {{$startFromYear}} @isset($endYear)-{{$endYear}} @endisset
		</div>
	@endif


	<div class="totalReports">
		 Total Reports:
		 {{$pdfArray['total_reports']}}
	</div>
</div>

<!--Reprosative Practice table PDF-->
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
<div class="reprosativePracticeDiv hide">
	<div class="reportHeader0">Restorative Practice</div>
	<div class="reprosativePractice practice_0">Self Awareness: {{round($selfAwareness,2)}}</div>
	<div class="reprosativePractice practice_1">Self Management: {{round($selfManagement,2)}}</div>
	<div class="reprosativePractice practice_2">Responsible Decision Making: {{round($decisioMaking,2)}}</div>
	<div class="reprosativePractice practice_3">Relationship Skills: {{round($relationshipSkills,2)}}</div>
	<div class="reprosativePractice practice_4">Social Awareness: {{round($socialAwareness,2)}}</div>
</div>
<!--Reprosative Practice table PDF Ends-->


<!--TimeReports For PDF DATA-->
<div class="timeReportsDiv hide">
	<div class="reportHeader1">Report</div>
	@php
	 $report =0;
	@endphp
@forelse($timeChart as $time)
	<div class="timeReports report_time{{$report}}">{{$time['time']}}: {{$time['reports']}}</div>
	@php
	 $report++;
	@endphp
 @empty
@endforelse
</div>
<!--TimeReports For PDF DATA ENds-->

<!--Male/Female Chart Pdf data-->
@php
$selfAwarenessMale   = round($gender['self_awareness']['Male'],2);
$selfAwarenessFemale = round($gender['self_awareness']['Female'],2);

$selfManagementMale   = round($gender['self_management']['Male'],2);
$selfManagementFemale = round($gender['self_management']['Female'],2);


$decisionMakingMale = round($gender['responsible_decision_making']['Male'],2);
$decisionMakingFemale = round($gender['responsible_decision_making']['Female'],2);

$relationshipSkillsMale = round($gender['relationship_skills']['Male'],2);
$relationshipSkillsFemale = round($gender['relationship_skills']['Female'],2);

$socialAwarenessMale = round($gender['social_awareness']['Male'],2);
$socialAwarenessFemale = round($gender['social_awareness']['Female'],2);
@endphp

<div class="genderReportsDiv hide">
	<div class="reportHeader2">Gender</div>
	<div class="genderReports gender_report_1_M" data-type="M" data-index="1">Self Awareness: Boys: {{$selfAwarenessMale}}</div>
	<div class="genderReports gender_report_1_F" data-type="F" data-index="1">Girls: {{$selfAwarenessFemale}}</div>

	<div class="genderReports gender_report_2_M" data-type="M" data-index="2">Self Management: Boys: {{$selfManagementMale}}</div>
	<div class="genderReports gender_report_2_F" data-type="F" data-index="2">Girls: {{$selfManagementFemale}}</div>

	<div class="genderReports gender_report_3_M" data-type="M" data-index="3">Responsible Decision Making: Boys: {{$decisionMakingMale}}</div>
	<div class="genderReports gender_report_3_F" data-type="F" data-index="3">Girls: {{$decisionMakingFemale}}</div>

	<div class="genderReports gender_report_4_M" data-type="M" data-index="4">Relationship Skills: Boys: {{$relationshipSkillsMale}}</div>
	<div class="genderReports gender_report_4_F" data-type="F" data-index="4">Girls: {{$relationshipSkillsFemale}}</div>

	<div class="genderReports gender_report_5_M" data-type="M" data-index="5">Social Awareness: Boys: {{$socialAwarenessMale}}</div>
	<div class="genderReports gender_report_5_F" data-type="F" data-index="5">Girls: {{$socialAwarenessFemale}}</div>
</div>
<!--Male/Female Chart Pdf data ends-->

<!--Behavior Data for PDF starts-->
<div class="behavioursReportsDiv hide">
	<div class="reportHeader3">Behavior</div>
@php
	$BehaviorShow = array('IN' => 0,'IL' => 0,'IC' => 0,'FI' => 0,'CD' => 0,'PI' =>0,'BU' =>0,'IA' =>0,'TT' =>0,'OT' =>0); 
	foreach($BehaviorShow as $key=>$value){
	 	if(array_search($key, array_column($Behavior, 'short_name')) !== false) {
	       $keyFind = array_search($key, array_column($Behavior, 'short_name'));
	       $BehaviorShow[$key] = $Behavior[$keyFind]->behaviors_count;
		}
	}

	$startBehavior = 1;
	foreach($BehaviorShow as $key => $behaviourForPdf){
@endphp
	<div class="behavioursReports behaviour_report{{$startBehavior}}">{{Config::get("constants.$key")}}: {{$behaviourForPdf}}</div>
@php
	$startBehavior++;
	}

@endphp
</div>

<!--Behavior Data for PDF Ends-->

<!--Behavior Data for PDF starts-->
<div class="locationReportsDiv hide">
	<div class="reportHeader4">Location</div>
	@php
		$LocationsShow = array('CL' => 0,'PL' => 0,'CA' => 0,'GY' => 0,'HA' => 0,'COA' =>0,'BA' =>0,'LI' =>0,'BU' =>0,'OT' =>0); 
		if(!empty($LocationsShow)){
			foreach($LocationsShow as $key=>$value){
			 	if(array_search($key, array_column($locations, 'short_name')) !== false) {
			       $keyFind = array_search($key, array_column($locations, 'short_name'));
			       $LocationsShow[$key] = $locations[$keyFind]->locations_count;
				}
			}
		}
		$allLocations = implode(",",$LocationsShow);/*used for charts-*/
 		$startLocation = 1;
	foreach($LocationsShow as $key => $locationReportsForPdf){
		@endphp
			<div class="locationsReports location_report{{$startLocation}}">{{Config::get("constants.$key")}}: {{$locationReportsForPdf}}</div>
		@php
			$startLocation++;
	}
	@endphp
</div>
<!--Behavior Data for PDF Ends-->

<!--Intervention Pdf Data starts-->
<div class="interventionReportsDiv hide">
	<div class="reportHeader5">Intervention</div>
@php
	$InterventionssShow = array('RPO' => 0,'LD' => 0,'ASD' => 0,'IS' => 0,'ES' => 0,'OT' =>0); 
	if(!empty($InterventionssShow)){
		foreach($InterventionssShow as $key=>$value){
		 	if(array_search($key, array_column($Interventions, 'short_name')) !== false) {
		       $keyFind = array_search($key, array_column($Interventions, 'short_name'));
		       $InterventionssShow[$key] = $Interventions[$keyFind]->interventions_count;
			}
		}
	}
	$allInterventions = implode(",",$InterventionssShow);/*Used for charts*/
	$startIntervention = 1;
	foreach($InterventionssShow as $key => $interventionReportsForPdf){
		@endphp
			<div class="interventionReports intervention_report{{$startIntervention}}">{{Config::get("constants.$key")}}: {{$interventionReportsForPdf}}</div>
		@php
			$startIntervention++;
	}
	@endphp
</div>
<!--Intervention Pdf Data ends-->
<!---Data Makes for PDf Ends-->

<section class="inner_home anylytc_home admin_analytcs">
	  <div class="col-md-12">
		<div class="top_filter">
				<h4>Filter By:</h4>
				<form class="filter_resilts" @if(isset($_GET['duration']) && $_GET['duration'] == "C") validate @else novalidate @endif >
					<div class="filter_input">
						<label>School</label>
						<select class="form-control select_schools" name="school">
							<option  value="">All Schools</option>
							@forelse($schools as $school)
								<option @isset($_GET['school']) @if($_GET['school'] == $school->id) selected @endif @endisset value="{{$school->id}}">{{$school->name}}</option>
							@empty
							@endforelse
						</select> 

					</div>
					<div class="filter_input">
						<label>Grade</label>
						@php
							$class="hide";
							if(isset($_GET['school']) && !empty(trim($_GET['school']))){
								$class="";
							}
						@endphp
						<select class="form-control select_grade" name="grade">
							<option value="" id="select_grades_option">All Grades</option>
								@forelse($grades as $grade)
									<option @isset($_GET['grade']) @if(trim($_GET['grade']) == $grade->id) selected @endif @endisset class="{{$class}}" value="{{$grade->id}}">{{$grade->name}}</option>
								@empty
								@endforelse
						</select>
					</div>
					<div class="filter_input">
						<label>Student</label>
						<select class="form-control students_appended" name="student">
							<option value="">All Students</option>
							<!--if filter is set for school and grade then get the stdentd of that grade of school-->
								@forelse($students as $student)
                                   <option @isset($_GET['student']) @if($_GET['student'] == $student->id) selected @endif @endisset value="{{$student->id}}">{{$student->name}}</option>
								@empty
								@endforelse
							<!--Append by ajax custom.js:-->
						  </select>
					</div>
					<div class="filter_input">
						<label>Time Period</label>
						<select class="form-control select_duration" name="duration">
							<option selected value="D">Daily</option>
							<option @if(isset($_GET['duration']) && trim($_GET['duration']) == "W") SELECTED @endif value="W">Weekly</option>
							<option @if(isset($_GET['duration']) && trim($_GET['duration']) == "M") SELECTED @endif value="M">Monthly</option>
							<option @if(isset($_GET['duration']) && trim($_GET['duration']) == "Y") SELECTED @endif value="Y">Yearly</option>
							<option @if(isset($_GET['duration']) && trim($_GET['duration']) == "C") SELECTED @endif value="C">Custom</option>
						</select>
					</div>

					<div class="custom_filter_inputs filter_input @if(isset($_GET['duration']) && $_GET['duration'] == 'C') show_fields @else hide @endif">
						<div class="filter_input">
							<label>Start Date</label>
								<input placeholder="Start Date" id="start_datepicker" class="form-control custom_filter_inpt" name="from_date" value="@isset($_GET['from_date']){{trim($_GET['from_date'])}}@endisset" autocomplete="off"  required/>
	      				</div>
          			</div>

					<div class="custom_filter_inputs filter_input @if(isset($_GET['duration']) && $_GET['duration'] == 'C') show_fields @else hide @endif">
						<div class="filter_input">
							<label>End Date</label>
							<input placeholder="End Date" id="end_datepicker" class="form-control custom_filter_inpt" name="to_date" value="@isset($_GET['to_date']){{trim($_GET['to_date'])}}@endisset" autocomplete="off"  required />
	      				</div>
	      				<label class="error start_end_date_err"></label>
					</div>
					
					<div class="filter_btn">
						<button class="btn btn-link btn-filter-submit">Submit</button>
					</div>
					</div>

				</form>
			</div>
	  </div>
	  <div class="col-md-12">
	  <div class="main_anyltc" id="main_anyltc">
<ul>
	 <Li> <div class="grade_listng">
	  <h4>Restorative Practice</h4>
				<div id="container2" class="myChart" style="height: 350px"></div>
				<ul class="grph_bar_line">
				<li><span>&nbsp;</span>SA- Self Awareness</li>
				<li><span>&nbsp;</span>SM- Self Management</li>
				<li><span>&nbsp;</span>RDM- Responsible Decision Making</li>
				<li><span>&nbsp;</span>RS- Relationship Skills</li>
				<li><span>&nbsp;</span>SA- Social Awareness </li>
				</ul>
				</div>
			</li>
			<Li>
				
				<div class="grade_listng bottm_grph">
	  <h4>Reports</h4>
				  <div id="container1" class="myChart" style="height: 350px"></div>
 
				</div>
				</li>
				
					<Li>
				
				<div class="grade_listng bottm_grph gender_grph">
	  <h4>Gender</h4>
				   <div id="container" class="myChart" style="height: 350px"></div>
				   	<ul class="grph_bar_line">
				<li><span>&nbsp;</span>Boys</li>
				<li><span>&nbsp;</span>Girls</li>
				</ul>
				</div>
				</li>
				
				
				<Li>
				
				<div class="grade_listng bottm_grph othr_beh_loc">
	  <h4>Behavior</h4>
	@php
		$BehaviorShow = array('IN' => 0,'IL' => 0,'IC' => 0,'FI' => 0,'CD' => 0,'PI' =>0,'BU' =>0,'IA' =>0,'TT' =>0,'OT' =>0); 
		foreach($BehaviorShow as $key=>$value){
		 	if(array_search($key, array_column($Behavior, 'short_name')) !== false) {
		       $keyFind = array_search($key, array_column($Behavior, 'short_name'));
		       $BehaviorShow[$key] = $Behavior[$keyFind]->behaviors_count;
			}
		}
		$allBehabiours = implode(",",$BehaviorShow);
	@endphp		  
 <div id="container3"  class="myChart" style="height: 350px"></div>
 	<ul class="grph_bar_line">
				<li><span>&nbsp;</span>IN- Insubordination</li>
				<li><span>&nbsp;</span>IL- Inappropriate Language</li>
				<li><span>&nbsp;</span>IC- Inappropriate Contact</li>
				<li><span>&nbsp;</span>FI- Fighting</li>
				<li><span>&nbsp;</span>CD- Classroom Disruption</li>
				<li><span>&nbsp;</span>PI- Property Infraction</li>
				<li><span>&nbsp;</span>BU- Bullying</li>
				<li><span>&nbsp;</span>IA- Inappropriate Attitude</li>
				<li><span>&nbsp;</span>TT- Tardy/Truant</li>
				<li><span>&nbsp;</span>OT- Other</li>
				</ul>
				
				</div>
				</li>
				
					<Li>
				
				<div class="grade_listng bottm_grph othr_beh_loc">
	  <h4>Location</h4>
  	<!--Locations Data Makes Here-->
	 
 <div id="container4" style="height: 350px"></div>
 	<ul class="grph_bar_line">
				<li><span>&nbsp;</span>CL- Classroom</li>
				<li><span>&nbsp;</span>PL- Playground</li>
				<li><span>&nbsp;</span>CA- Cafeteria</li>
				<li><span>&nbsp;</span>GY- Gym</li>
				<li><span>&nbsp;</span>HA- Hallway</li>
				<li><span>&nbsp;</span>COA- Common Area</li>
				<li><span>&nbsp;</span>BA- Bathroom</li>
				<li><span>&nbsp;</span>LI- Library</li>
				<li><span>&nbsp;</span>BU- Bus</li>
				<li><span>&nbsp;</span>OT- Other</li>
				</ul>
				
				</div>
				</li>				
				
				<Li>
					<div class="grade_listng bottm_grph othr_beh_loc">
						<h4>Intervention</h4>
						

						<div id="container5" style="height: 350px"></div>
							<ul class="grph_bar_line">
								<li><span>&nbsp;</span>RPO- Restorative Practice Only</li>
								<li><span>&nbsp;</span>LD- Lunch Detention</li>
								<li><span>&nbsp;</span>ASD- After School Detention</li>
								<li><span>&nbsp;</span>IS- Internal Suspension</li>
								<li><span>&nbsp;</span>ES- External Suspension</li>
								<li><span style="background-color:#8f8c90">&nbsp;</span>OT- Other</li>
							</ul>
					</div>
				</li>
				
				
</ul>
				</div>
				
</div>

<div class="col-md-12">
	<div class="note_sction">
		<h4>Notes</h4>
		<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words
which don't look even slightly believable. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by
injected humour, or randomised words which don't look even slightly believable.</p>
	</div>
</div>
	
<div class="col-md-12 text-center">
	<div class="btn_downld">
		<!-- <button class="btn btn-link download-pdf"><img src="{{URL::to('/')}}/public/images/download.png">DOWNLOAD PDF REPORT</button> -->
		<button class="btn btn-link download-pdf"><img src="{{URL::to('/')}}/public/images/download.png">DOWNLOAD PDF REPORT</button>
		<!--Download function in custom.js-->
	</div>
</div>

</section>
<section class="footer_inner">
<!-- footer section start -->
	<p>&copy; Copyright {{date('Y')}}. All Rights Reserved.</p>
<!-- footer section end -->
</section>
<!-- <script src="https://code.highcharts.com/modules/exporting.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/7.1.2/modules/exporting.js"></script>
<script src="{{URL::to('/')}}/public/js/custom.js"></script>

<script>
/*var chart = Highcharts.chart('container2', {

  title: {
    text: ''
  },

  subtitle: {
    text: ''
  },

  xAxis: {
    categories: ['SA', 'SM', 'RDM', 'RS', 'SA']
  },

  series: [{
  name: 'RP',
    type: 'column',
    colorByPoint: true,
	colors: "#805f85 #4c7fbe #76a229 #f9963c #31538c".split(" "),
    data: [2, 3, 1, 2, 2],
    showInLegend: false
  }]

});*/
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
   exporting: {
    enabled: false, // hide button
    allowHTML:true,
    showTable: true,
  },
  plotOptions: {
        column: {
            /* Here is the setting to limit the maximum column width. */
            maxPointWidth: 50,
            dataLabels: {
                enabled: true,
                crop: false,
                overflow: 'none'
            }
        }
    },
  xAxis: {
    /*categories:['7 AM', '8 AM', '9 AM', '10 AM', '11 AM', '12 AM', '1 PM', '2 PM', '3 PM', '4 PM']*/
  	categories:[{!! $timePerios !!}]

  },

  series: [{
  name: 'Reports',
    type: 'column',
    colorByPoint: true,
	colors: "#4479ff #4479ff #4479ff #4479ff #4479ff".split(" "),
    /*data: [6, 12, 8, 14, 12, 8, 12, 10, 3, 8],*/
    data: [{{$timeReports}}],
    showInLegend: false
  }]

});

</script>
<script>
Highcharts.chart('container', {

    chart: {
        type: 'column',
        //styledMode: true
    },
	title: {
        text: ''
    },
    xAxis: {
        categories: ['SA', 'SM', 'RDM', 'RS', 'SA']
    },
    yAxis: [{
        className: 'highcharts-color-0',
        title: {
            text: ''
        }
    }, {
        className: 'highcharts-color-1',
        opposite: false,
        title: {
            text: ''
        }
    }],

    plotOptions: {
        column: {
            borderRadius: 0,
            dataLabels: {
                enabled: true,
                crop: false,
                overflow: 'none'
            }
        },
       
        series: {
        	states: {
		      inactive: {
		        opacity: 1
		      }
		    }
	  }
    },
    exporting: {
    	enabled: false, // hide button
    	allowHTML:true,
    	showTable: true,
  	},
    series: [{
	 name: 'Male',
        data: [{{$selfAwarenessMale}}, {{$selfManagementMale}}, {{$decisionMakingMale}}, {{$relationshipSkillsMale}}, {{$socialAwarenessMale}}],
		showInLegend: false

		/*yAxis: 1*/
    }, {
	 name: 'Female',
        data: [{{$selfAwarenessFemale}}, {{$selfManagementFemale}}, {{$decisionMakingFemale}}, {{$relationshipSkillsFemale}}, {{$socialAwarenessFemale}}],
		showInLegend: false,
		color: '#ce6ddd',
		/*yAxis: 1*/
    }]

});
</script>
<script>
var chart = Highcharts.chart('container2', {
  title: {
    text: ''
  },

  subtitle: {
    text: ''
  },

  xAxis: {
    categories: ['SA', 'SM', 'RDM', 'RS', 'SA']
  },
  exporting: {
    enabled: false, // hide button
    allowHTML:true,
    showTable: true,
  },
  plotOptions: {
        column: {
            dataLabels: {
                enabled: true,
                crop: false,
                overflow: 'none'
            }
        }
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
var chart = Highcharts.chart('container3', {

  title: {
    text: ''
  },

  subtitle: {
    text: ''
  },

  xAxis: {
    categories: ['IN', 'IL', 'IC', 'FI', 'CD', 'PI', 'BU', 'IA', 'TT', 'OT' ]
  },
  exporting: {
    enabled: false, // hide button
    allowHTML:true,
    showTable: true,
  },
  plotOptions: {
        column: {
            dataLabels: {
                enabled: true,
                crop: false,
                overflow: 'none'
            }
        }
    },
  series: [{
  name: 'Behavior',
    type: 'column',
    colorByPoint: true,
	colors: "#9c00d9 #308482 #f9963c #ff0000 #1a386e #805f85 #3c3c3c #ffde48 #b5507b #8f8c90".split(" "),
    data: [{{$allBehabiours}}],
    showInLegend: false
  }]

});   

</script>
<script>
var chart = Highcharts.chart('container4', {

  title: {
    text: ''
  },

  subtitle: {
    text: ''
  },

  xAxis: {
    categories: ['CL', 'PL', 'CA', 'GY', 'HA', 'COA', 'BA', 'LI', 'BU', 'OT' ]
  },
  exporting: {
    enabled: false, // hide button
    allowHTML:true,
    showTable: true,
  },
  plotOptions: {
        column: {
            dataLabels: {
                enabled: true,
                crop: false,
                overflow: 'none'
            }
        }
    },
  series: [{
   name: 'Location',
    type: 'column',
    colorByPoint: true,
	colors: "#9c00d9 #308482 #f9963c #ff0000 #1a386e #805f85 #3c3c3c #ffde48 #b5507b #8f8c90".split(" "),
    /*data: [40, 60, 50, 20, 55, 20, 45, 55, 30, 72],*/
    data: [{{$allLocations}}],
    showInLegend: false
  }]

});
</script>
<script>
var chart = Highcharts.chart('container5', {
  title: {
    text: ''
  },

  subtitle: {
    text: ''
  },

  xAxis: {
    categories: ['RPO', 'LD', 'ASD', 'IS', 'ES', 'OT' ]
  },
  exporting: {
    enabled: false, // hide button
    allowHTML:true,
    showTable: true,
  },
    plotOptions: {
        column: {
            dataLabels: {
                enabled: true,
                crop: false,
                overflow: 'none'
            }
        }
    },
  series: [{
    name: 'Intervention',
    type: 'column',
    colorByPoint: true,
	colors: "#9c00d9 #308482 #f9963c #ff0000 #1a386e #8f8c90".split(" "),
    data: [{{$allInterventions}}],
    showInLegend: false
  }]

});
</script>
<script type="text/javascript">
function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[0]-1, mdy[1]);
}

function datediff(first, second) {
    // Take the difference between the dates and divide by milliseconds per day.
    // Round to nearest whole number to deal with DST.
    return Math.round((second-first)/(1000*60*60*24));
}
function checkDifferenceBetweenDate(){
	$(".start_end_date_err").html('');

	var start_date = $("#start_datepicker").val();
	var endDate    = $("#end_datepicker").val();
 
	var start = new Date(start_date),  
    end   = new Date(endDate),   
    diff  = new Date(end - start),  
    days  = diff/1000/60/60/24;  

    if(days > 30){
    	// /alert("Cant not select more than 30 days");
    	$(".start_end_date_err").html("Can't not select more than 30 days");
    	return 0;
    }else if(days < 0){
    	$(".start_end_date_err").html("Start date should be grater than end date");
    	return 0;
    }
    return 1;
}

 var minDate = moment();
 var maxDate = minDate;
  $("#start_datepicker").datetimepicker({
    	format: "ll",
	    maxDate: maxDate,
	    @if(!isset($_GET['from_date']) && empty($_GET['from_date']))
    		useCurrent:true,
    		@else 
    		useCurrent:false,
    	@endif
	    icons: {
	      next: "fa fa-chevron-right",
	      previous: "fa fa-chevron-left"
	    }
  }).on('dp.change', function(e){
  	     var checkDate = checkDifferenceBetweenDate();
  		 if(checkDate == 0){
  		 	$("#start_datepicker").val('');
  		 }

  });

$("#end_datepicker").datetimepicker({
    format: "ll",
    maxDate: maxDate,
    @if(!isset($_GET['to_date']) && empty($_GET['to_date']))
    	useCurrent:true,
    	@else 
    	useCurrent:false,
    @endif
    /*minDate: moment(),
    maxDate: maxDate,*/
   /* useCurrent:false,*/
    icons: {
      next: "fa fa-chevron-right",
      previous: "fa fa-chevron-left"
    }
  }).on('dp.change', function(e){
  	  var checkDate = checkDifferenceBetweenDate();
  	  if(checkDate == 0){
  		 	$("#end_datepicker").val('');
  	   }
  });


</script>
<script>
$(".select_duration").on('change', function() {
	  var selectedValue = this.value;
	  if(selectedValue == "C"){
	  	$(".custom_filter_inputs").removeClass("hide");
	  	$(".custom_filter_inpt").css("display","block").attr("required",true);
	  	$("form").removeAttr("novalidate");
	  }else{
	  	$(".custom_filter_inpt").val('');
	  	$(".custom_filter_inputs").addClass("hide");
	  	$(".custom_filter_inpt").css("display","none").attr("required",false);
	  	$("form").attr("novalidate",true);
	  }
});
</script>
</body>
</html>


