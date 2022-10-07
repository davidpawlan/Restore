<!DOCTYPE html>
<html lang="en">
<head>
  <title>Restore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/style.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/highcharts.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet' href='{{URL::to("/")}}/public/css/bootstrap-datetimepicker.min.css'>
  <script src="{{URL::to('/')}}/public/js/jquery.min.js"></script>
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/custom.css">
  <script src="{{URL::to('/')}}/public/js/bootstrap.min.js"></script>
  <script src="{{URL::to('/')}}/public/js/highcharts.js"></script>
  <script src="{{URL::to('/')}}/public/js/highcharts-more.js"></script>
  <script src="{{URL::to('/')}}/public/js/draggable-points.js"></script>

  <script src="{{URL::to('/')}}/public/js/moment.min.js"></script>
  <script src="{{URL::to('/')}}/public/js/bootstrap-datetimepicker.min.js"></script>
  <style>
    .li_daily{
    	    border-top-right-radius: 0px !important;
		    border-bottom-right-radius: 0px !important;
		    border-right: 1px solid #162856;
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
<style>
#container .highcharts-color-1 {
	fill: #ce6ddd!important;
	stroke: #ce6ddd;
}
</style>
<!--Include Header-->
@include("Elements.school_header")



<div class="modal fade add_notespopup" id="chnge_pswd" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content report_inner">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="{{URL::to('/')}}/public/images/close.png"></button>
                <h4 class="modal-title">Do you want to add any specific note ?</h4>
        </div>
        <div class="modal-body">
			    	<div class="row form-group">
						<div class="col-md-12">
							<label>Notes</label>
								<textarea name="notes" class="form-control notes_for_pdf" placeholder="Enter Notes(Optional)"/></textarea>
						</div>
					</div>
					<div class="row text-center">
						<div class="col-md-12 btn_submit">
							<button type="submit" class="btn btn-link btn-submit download-pdf"> Download <i class="fa fa-spinner fa-spin spinner_show hide" aria-hidden="true"></i></button>
						</div>
					</div>
				
        	</div>
      </div>
    </div>
  </div>



<!---Data Makes for PDf starts-->
<!---Data for PDF header-->
<div class="pdfHeaderEport hide">
	<div class="SchoolInfo">
		School: 
		{{$pdfArray['school']}}
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
				 To: {{date("m/d/Y",strtotime($pdfArray['end_date']))}}
			</div>
	    @elseif($timePeriod == "D")
		 	<div class="timePeriodDetails">
				 Date: {{date("m/d/Y",strtotime($pdfArray['start_date']))}} 
			</div>
		@elseif($timePeriod == "W")
	 	<div class="timePeriodDetails">
				 From: {{date("m/d/Y",strtotime($pdfArray['start_date']))}}
				 To: {{date("m/d/Y",strtotime(date("Y-m-d")))}} 
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
	<div class="reportHeader3">Referred Need</div>
@php
	$BehaviorShow = array('CO' => 0,'GR' => 0,'PS' => 0,'SC' => 0,'PT' => 0,'FI' =>0,'PI' =>0,'EF' =>0,'SR' =>0,'OT' =>0);
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
	<div class="reportHeader4">Service</div>
	@php
		$LocationsShow = array('IN' => 0,'SG' => 0,'PC' => 0,'SC' => 0,'OB' => 0,'CRB' =>0,'AS' =>0,'CM' =>0,'PC' =>0,'OT' =>0);
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
	<div class="reportHeader5">Demographics</div>
@php
	$InterventionssShow = array('HF' => 0,'HM' => 0,'AAF' => 0,'AAM' => 0,'OF' => 0,'OM' =>0);
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




<section class="inner_home anylytc_home ">
	  <div class="col-md-12">
	 <form action="{{URL::to('/')}}/analytics" @if(isset($_GET['duration']) && $_GET['duration'] == "C") validate @else novalidate @endif >

			<div class="top_filter">
					<h4>Filter By:</h4>
				<!--<div class="filter_input">
					<label>School</label>
					<select class="form-control">
								<option>Select School</option>
								<option>A</option>
								<option>B</option>
								<option>C</option>
								<option>D</option>
							  </select>
				</div>-->
				<select class="select_schools hide">
					<option value="{{Auth::id()}}" selected>{{Auth::id()}}</option>
				</select>

				<div class="filter_input">
					<label>Grade</label>
					<select name="grade" class="form-control select_grade">
						<option value="">All Grades</option>
						@forelse($grades as $grade)
							<option @isset($_GET['grade']) @if($_GET['grade'] == $grade->id) SELECTED @endif @endisset value="{{$grade->id}}">{{$grade->name}}</option>
						@empty
						@endforelse
					</select>
				</div>
					<div class="filter_input">
					<label>Student</label>
					<select name="student" class="form-control students_appended">
						<option value="">All Students</option>
						@forelse($students as $student)
						   <option @isset($_GET['student']) @if($_GET['student'] == $student->id) SELECTED @endif @endisset value="{{$student->id}}">{{$student->name}}</option>
						@empty
						@endforelse
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
	      				<div class="clearfix"></div>
	      				<br/>
	      				<label class="error start_end_date_err"></label>
	      			</div>

				<div class="filter_btn">
					<button class="btn btn-link">Submit</button>
				</div>
			</div>
		</form>
	  </div>
	 <div class="col-md-12">
	  <div class="main_anyltc">
<ul>
	 <Li> <div class="grade_listng">
	  <h4>Restorative Practice</h4>
				<div id="container2" style="height: 350px"></div>
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
				@php
					$urlQuery="";
					if(isset($_GET['grade']) && !empty($_GET['grade'])){
						$urlQuery .= "grade=".$_GET['grade'];
					}
					if(isset($_GET['student']) && !empty($_GET['student'])){
						$urlQuery .= "&student=".$_GET['student'];
					}
				@endphp
				<div class="grade_listng bottm_grph analytc_sctn">
	  			<div> <h4>Reports</h4>
					<!-- <div class="daily_wekly">
						<ul >
							<li class="li_daily @if(isset($_GET['filter']) && $_GET['filter'] == 'D')active @endif"><a href="{{URL::to('/')}}/analytics?filter=D&{{$urlQuery}}">Daily</a></li>
							<li class="@if(isset($_GET['filter']) && $_GET['filter'] == 'W')active @endif"><a href="{{URL::to('/')}}/analytics?filter=W&{{$urlQuery}}">Weekly</a></li>
						</ul>
				  	</div> -->
				  </div>
				<div id="container1" style="height: 350px"></div>
 
				</div>
				</li>
				<li>
				
					<div class="grade_listng bottm_grph gender_grph">
		  				<h4>Gender</h4>
					   <div id="container" style="height: 350px"></div>
					   	<ul class="grph_bar_line">
							<li><span>&nbsp;</span>Boys</li>
							<li><span>&nbsp;</span>Girls</li>
						</ul>
					</div>
				</li>
			<li>
	 <div class="grade_listng bottm_grph othr_beh_loc">
	  <h4>Referred Need</h4>
				  
 <div id="container3" style="height: 350px"></div>
 	<ul class="grph_bar_line">
				<li><span>&nbsp;</span>CO- Coping</li>
				<li><span>&nbsp;</span>GR- Grief</li>
				<li><span>&nbsp;</span>PS- Problem Solving</li>
				<li><span>&nbsp;</span>SC- Social Communication</li>
				<li><span>&nbsp;</span>PT- Perspective Taking</li>
				<li><span>&nbsp;</span>FI- Family Issues</li>
				<li><span>&nbsp;</span>PI- Peer Issues</li>
				<li><span>&nbsp;</span>EF- Executive Functioning</li>
				<li><span>&nbsp;</span>SR- Self-Regulation</li>
				<li><span>&nbsp;</span>OT- Other</li>
				</ul>
				
				</div>
				</li>
				<li>
					<div class="grade_listng bottm_grph othr_beh_loc">
					<h4>Service</h4>
					<div id="container4" style="height: 350px"></div>
		 				<ul class="grph_bar_line">
							<li><span>&nbsp;</span>IN- Individual</li>
							<li><span>&nbsp;</span>SG- Small Group</li>
							<li><span>&nbsp;</span>PC- Principal Consultation</li>
							<li><span>&nbsp;</span>SC- Staff Consultation</li>
							<li><span>&nbsp;</span>OB- Observation</li>
							<li><span>&nbsp;</span>CRB- Class-Room Based</li>
							<li><span>&nbsp;</span>AS- Assessment</li>
							<li><span>&nbsp;</span>CM- Crisis Management</li>
							<li><span>&nbsp;</span>PC- Parent Communication</li>
							<li><span>&nbsp;</span>OT- Other</li>
						</ul>
					</div>
				</li>
			<li>
				<div class="grade_listng bottm_grph othr_beh_loc">
	  				<h4>Demographics</h4>
					<div id="container5" style="height: 350px"></div>
						 <ul class="grph_bar_line">
										<li><span>&nbsp;</span>HF- Hispanic Female</li>
										<li><span>&nbsp;</span>HM- Hispanic Male</li>
										<li><span>&nbsp;</span>AAF- AA Female</li>
										<li><span>&nbsp;</span>AAM- AA Male</li>
										<li><span>&nbsp;</span>OF- Other Female</li>
										<li><span style="background-color:#8f8c90">&nbsp;</span>OM- Other Male</li>
										</ul>
										
										</div>
										</li>
										
										
						</ul>
					</div>
				</div>

<div class="col-md-12">
	<div class="note_sction hide">
		<h4>Notes</h4>
		<P>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words
which don't look even slightly believable. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by
injected humour, or randomised words which don't look even slightly believable.</p>
	</div>
</div>
	
<div class="col-md-12 text-center">
	<div class="btn_downld">
		<button data-toggle="modal" data-target="#chnge_pswd" class="btn btn-link download-pdf1 add_notes_pdf"><img src="{{URL::to('/')}}/public/images/download.png">DOWNLOAD PDF REPORT</button>
		<!-- <button class="btn btn-link download-pdf1"><img src="{{URl::to('/')}}/public/images/download.png">DOWNLOAD PDF REPORT</button> -->
	</div>
</div>

</section>


<section class="footer_inner">
<!-- footer section start -->
	<p>&copy; Copyright 2019. All Rights Reserved.</p>
<!-- footer section end -->
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/7.1.2/modules/exporting.js"></script>
<script src="{{URL::to('/')}}/public/js/custom.js"></script>

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
  },

  xAxis: {
    /*categories:['7 AM', '8 AM', '9 AM', '10 AM', '11 AM', '12 AM', '1 PM', '2 PM', '3 PM', '4 PM']*/
	categories:[{!! $timePerios !!}]

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
<script>
Highcharts.chart('container', {

    chart: {
        type: 'column'
        /*styledMode: true*/
    },
    exporting: {
    enabled: false, // hide button
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
    series: [{
	 name: 'Male',
        /* data: [2, 2, 2, 1, 1],*/
        data: [{{$selfAwarenessMale}}, {{$selfManagementMale}}, {{$decisionMakingMale}}, {{$relationshipSkillsMale}}, {{$socialAwarenessMale}}],
		showInLegend: false
	}, {
	 name: 'Female',
       /* data: [1, 3, 2, 2, 1],*/
        data: [{{$selfAwarenessFemale}}, {{$selfManagementFemale}}, {{$decisionMakingFemale}}, {{$relationshipSkillsFemale}}, {{$socialAwarenessFemale}}],
		showInLegend: false,
        color: '#ce6ddd',
    }]

});
</script> 
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
var chart = Highcharts.chart('container2', {

  title: {
    text: ''
  },

  subtitle: {
    text: ''
  },
  /*exporting: {
    enabled: false, // hide button
  },*/
  exporting:{
  	enabled: false,
        chartOptions:{
            title: {
                text:'aaaaa'
            }
        }
    },

  xAxis: {
    categories: ['SA', 'SM', 'RDM', 'RS', 'SA']
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
@php
	$BehaviorShow = array('CO' => 0,'GR' => 0,'PS' => 0,'SC' => 0,'PT' => 0,'FI' =>0,'PI' =>0,'EF' =>0,'SR' =>0,'OT' =>0); 
	foreach($BehaviorShow as $key=>$value){
	 	if(array_search($key, array_column($Behavior, 'short_name')) !== false) {
	       $keyFind = array_search($key, array_column($Behavior, 'short_name'));
	       $BehaviorShow[$key] = $Behavior[$keyFind]->behaviors_count;
		}
	}
	$allBehabiours = implode(",",$BehaviorShow);
@endphp
<script>
var chart = Highcharts.chart('container3', {

  title: {
    text: ''
  },

  subtitle: {
    text: ''
  },

  xAxis: {
    categories: ['CO', 'GR', 'PS', 'SC', 'PT', 'FI', 'PI', 'EF', 'SR', 'OT' ]
  },
  exporting: {
    enabled: false, // hide button
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
  name: 'Referred Need',
    type: 'column',
    colorByPoint: true,
	colors: "#9c00d9 #308482 #f9963c #ff0000 #1a386e #805f85 #3c3c3c #ffde48 #b5507b #8f8c90".split(" "),
    data: [{{$allBehabiours}}],
    showInLegend: false
  }]

});   

</script>
@php
	$LocationsShow = array('IN' => 0,'SG' => 0,'PC' => 0,'SC' => 0,'OB' => 0,'CRB' =>0,'AS' =>0,'CM' =>0,'PC' =>0,'OT' =>0); 
	if(!empty($LocationsShow)){
		foreach($LocationsShow as $key=>$value){
		 	if(array_search($key, array_column($locations, 'short_name')) !== false) {
		       $keyFind = array_search($key, array_column($locations, 'short_name'));
		       $LocationsShow[$key] = $locations[$keyFind]->locations_count;
			}
		}
	}
	$allLocations = implode(",",$LocationsShow);
@endphp 
<script>
var chart = Highcharts.chart('container4', {

  title: {
    text: ''
  },
  exporting: {
    enabled: false, // hide button
  },
  subtitle: {
    text: ''
  },

  xAxis: {
    categories: ['IN', 'SG', 'PC', 'SC', 'OB', 'CRB', 'AS', 'CM', 'PC', 'OT' ]
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
   name: 'Service',
    type: 'column',
    colorByPoint: true,
	colors: "#9c00d9 #308482 #f9963c #ff0000 #1a386e #805f85 #3c3c3c #ffde48 #b5507b #8f8c90".split(" "),
    data: [{{$allLocations}}],
    showInLegend: false
  }]

});
</script>
@php
	$InterventionssShow = array('HF' => 0,'HM' => 0,'AAF' => 0,'AAM' => 0,'OF' => 0,'OM' =>0); 
	if(!empty($InterventionssShow)){
		foreach($InterventionssShow as $key=>$value){
		 	if(array_search($key, array_column($Interventions, 'short_name')) !== false) {
		       $keyFind = array_search($key, array_column($Interventions, 'short_name'));
		       $InterventionssShow[$key] = $Interventions[$keyFind]->interventions_count;
			}
		}
	}
	$allInterventions = implode(",",$InterventionssShow);
@endphp
<script>
var chart = Highcharts.chart('container5', {

  title: {
    text: ''
  },
  exporting: {
    enabled: false, // hide button
  },
  subtitle: {
    text: ''
  },

  xAxis: {
    categories: ['HF', 'HM', 'AAF', 'AAM', 'OF', 'OM' ]
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
    name: 'Demographics',
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
    	format: 'MM/DD/YYYY',
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
    format: 'MM/DD/YYYY',
    maxDate: maxDate,
    @if(!isset($_GET['to_date']) && empty($_GET['to_date']))
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
  		 	$("#end_datepicker").val('');
  	   }
  });
</script>
@if(!isset($_GET['from_date']) && empty($_GET['from_date']))
<script>
//$("#start_datepicker").val('');
</script>
@endif
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


