<!DOCTYPE html>
<html lang="en">
<head>
  <title>Restore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/style.css">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/highcharts.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet' href='<?php echo e(URL::to("/")); ?>/public/css/bootstrap-datetimepicker.min.css'>
  <script src="<?php echo e(URL::to('/')); ?>/public/js/jquery.min.js"></script>
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/custom.css">
  <script src="<?php echo e(URL::to('/')); ?>/public/js/bootstrap.min.js"></script>
  <script src="<?php echo e(URL::to('/')); ?>/public/js/highcharts.js"></script>
  <script src="<?php echo e(URL::to('/')); ?>/public/js/highcharts-more.js"></script>
  <script src="<?php echo e(URL::to('/')); ?>/public/js/draggable-points.js"></script>

  <script src="<?php echo e(URL::to('/')); ?>/public/js/moment.min.js"></script>
  <script src="<?php echo e(URL::to('/')); ?>/public/js/bootstrap-datetimepicker.min.js"></script>
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
<?php echo $__env->make("Elements.school_header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<div class="modal fade add_notespopup" id="chnge_pswd" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content report_inner">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="<?php echo e(URL::to('/')); ?>/public/images/close.png"></button>
          <h4 class="modal-title">Add Note</h4>
        </div>
        <div class="modal-body">
			    	<div class="row form-group">
						<div class="col-md-12">
							<label>Notes</label>
								<textarea name="notes" class="form-control notes_for_pdf" placeholder="Enter Notes"/></textarea>
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
		<?php echo e($pdfArray['school']); ?>

	</div>
	<div class="gradeInfo">
		Grade: 
		<?php echo e($pdfArray['grade']); ?>

	</div>

	<?php if($pdfArray['total_grade'] != 1): ?>
	<div class="totalgrades">
		Total No. of Grades:
		<?php echo e($pdfArray['total_grade']); ?>

	</div>
	<?php endif; ?>
	<div class="studentInfo">
		Student: 
		<?php echo e($pdfArray['student']); ?>

	</div>
	<?php if($pdfArray['total_student'] != 1): ?>
	<div class="totalStudents">
		 Total No. of Students:
		 <?php echo e($pdfArray['total_student']); ?>

	</div>
	<?php endif; ?>
	<div class="timePeriodInfo">
		 Time Period:
		 <?php echo e($pdfArray['time_period']); ?>

	</div>
	<?php
		if(isset($_GET['duration']) && !empty(trim($_GET['duration']))){
           $timePeriod  = $_GET['duration'];
	    }else{	
	    	$timePeriod = "D";
		}
	?>

	<?php if($timePeriod == "C"): ?>
			<div class="timePeriodDetails">
				 From:  <?php echo e(date("d M, Y",strtotime($pdfArray['start_date']))); ?> 
				 To: <?php echo e(date("d M, Y",strtotime($pdfArray['end_date']))); ?>

			</div>
	    <?php elseif($timePeriod == "D"): ?>
		 	<div class="timePeriodDetails">
				 Date: <?php echo e(date("d M, Y",strtotime($pdfArray['start_date']))); ?> 
			</div>
		<?php elseif($timePeriod == "W"): ?>
	 	<div class="timePeriodDetails">
				 From: <?php echo e(date("d M, Y",strtotime($pdfArray['start_date']))); ?>

				 To: <?php echo e(date("d M, Y",strtotime(date("Y-m-d")))); ?> 
		</div>
		<?php elseif($timePeriod == "M"): ?>
	 	<div class="timePeriodDetails">
				 Month: <?php echo e(date("F",strtotime($pdfArray['start_date']))); ?>

		</div>
		<?php elseif($timePeriod == "Y"): ?>
	 	<div class="timePeriodDetails">
			<?php
	 			$startFromYear = date("Y",strtotime($pdfArray['start_date']));
	 			if(date("Y") > $startFromYear){
	 			 $endYear = date("Y");
	 			}
	 		?>
			Year: <?php echo e($startFromYear); ?> <?php if(isset($endYear)): ?>-<?php echo e($endYear); ?> <?php endif; ?>
		</div>
	<?php endif; ?>


	<div class="totalReports">
		 Total Reports:
		 <?php echo e($pdfArray['total_reports']); ?>

	</div>
</div>

<!--Reprosative Practice table PDF-->
<?php
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
?>
<div class="reprosativePracticeDiv hide">
	<div class="reportHeader0">Restorative Practice</div>
	<div class="reprosativePractice practice_0">Self Awareness: <?php echo e(round($selfAwareness,2)); ?></div>
	<div class="reprosativePractice practice_1">Self Management: <?php echo e(round($selfManagement,2)); ?></div>
	<div class="reprosativePractice practice_2">Responsible Decision Making: <?php echo e(round($decisioMaking,2)); ?></div>
	<div class="reprosativePractice practice_3">Relationship Skills: <?php echo e(round($relationshipSkills,2)); ?></div>
	<div class="reprosativePractice practice_4">Social Awareness: <?php echo e(round($socialAwareness,2)); ?></div>
</div>
<!--Reprosative Practice table PDF Ends-->


<!--TimeReports For PDF DATA-->
<div class="timeReportsDiv hide">
	<div class="reportHeader1">Report</div>
	<?php
	 $report =0;
	?>
<?php $__empty_1 = true; $__currentLoopData = $timeChart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
	<div class="timeReports report_time<?php echo e($report); ?>"><?php echo e($time['time']); ?>: <?php echo e($time['reports']); ?></div>
	<?php
	 $report++;
	?>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<?php endif; ?>
</div>
<!--TimeReports For PDF DATA ENds-->

<!--Male/Female Chart Pdf data-->
<?php
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
?>

<div class="genderReportsDiv hide">
	<div class="reportHeader2">Gender</div>
	<div class="genderReports gender_report_1_M" data-type="M" data-index="1">Self Awareness: Boys: <?php echo e($selfAwarenessMale); ?></div>
	<div class="genderReports gender_report_1_F" data-type="F" data-index="1">Girls: <?php echo e($selfAwarenessFemale); ?></div>

	<div class="genderReports gender_report_2_M" data-type="M" data-index="2">Self Management: Boys: <?php echo e($selfManagementMale); ?></div>
	<div class="genderReports gender_report_2_F" data-type="F" data-index="2">Girls: <?php echo e($selfManagementFemale); ?></div>

	<div class="genderReports gender_report_3_M" data-type="M" data-index="3">Responsible Decision Making: Boys: <?php echo e($decisionMakingMale); ?></div>
	<div class="genderReports gender_report_3_F" data-type="F" data-index="3">Girls: <?php echo e($decisionMakingFemale); ?></div>

	<div class="genderReports gender_report_4_M" data-type="M" data-index="4">Relationship Skills: Boys: <?php echo e($relationshipSkillsMale); ?></div>
	<div class="genderReports gender_report_4_F" data-type="F" data-index="4">Girls: <?php echo e($relationshipSkillsFemale); ?></div>

	<div class="genderReports gender_report_5_M" data-type="M" data-index="5">Social Awareness: Boys: <?php echo e($socialAwarenessMale); ?></div>
	<div class="genderReports gender_report_5_F" data-type="F" data-index="5">Girls: <?php echo e($socialAwarenessFemale); ?></div>
</div>
<!--Male/Female Chart Pdf data ends-->

<!--Behavior Data for PDF starts-->
<div class="behavioursReportsDiv hide">
	<div class="reportHeader3">Behavior</div>
<?php
	$BehaviorShow = array('IN' => 0,'IL' => 0,'IC' => 0,'FI' => 0,'CD' => 0,'PI' =>0,'BU' =>0,'IA' =>0,'TT' =>0,'OT' =>0); 
	foreach($BehaviorShow as $key=>$value){
	 	if(array_search($key, array_column($Behavior, 'short_name')) !== false) {
	       $keyFind = array_search($key, array_column($Behavior, 'short_name'));
	       $BehaviorShow[$key] = $Behavior[$keyFind]->behaviors_count;
		}
	}
	$startBehavior = 1;
	foreach($BehaviorShow as $key => $behaviourForPdf){
?>
	<div class="behavioursReports behaviour_report<?php echo e($startBehavior); ?>"><?php echo e(Config::get("constants.$key")); ?>: <?php echo e($behaviourForPdf); ?></div>
<?php
	$startBehavior++;
	}
?>
</div>

<!--Behavior Data for PDF Ends-->

<!--Behavior Data for PDF starts-->
<div class="locationReportsDiv hide">
	<div class="reportHeader4">Location</div>
	<?php
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
		?>
			<div class="locationsReports location_report<?php echo e($startLocation); ?>"><?php echo e(Config::get("constants.$key")); ?>: <?php echo e($locationReportsForPdf); ?></div>
		<?php
			$startLocation++;
	}
	?>
</div>
<!--Behavior Data for PDF Ends-->

<!--Intervention Pdf Data starts-->
<div class="interventionReportsDiv hide">
	<div class="reportHeader5">Intervention</div>
<?php
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
		?>
			<div class="interventionReports intervention_report<?php echo e($startIntervention); ?>"><?php echo e(Config::get("constants.$key")); ?>: <?php echo e($interventionReportsForPdf); ?></div>
		<?php
			$startIntervention++;
	}
	?>
</div>
<!--Intervention Pdf Data ends-->
<!---Data Makes for PDf Ends-->




<section class="inner_home anylytc_home ">
	  <div class="col-md-12">
	 <form action="<?php echo e(URL::to('/')); ?>/analytics" <?php if(isset($_GET['duration']) && $_GET['duration'] == "C"): ?> validate <?php else: ?> novalidate <?php endif; ?> >

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
					<option value="<?php echo e(Auth::id()); ?>" selected><?php echo e(Auth::id()); ?></option>
				</select>

				<div class="filter_input">
					<label>Grade</label>
					<select name="grade" class="form-control select_grade">
						<option value="">All Grades</option>
						<?php $__empty_1 = true; $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
							<option <?php if(isset($_GET['grade'])): ?> <?php if($_GET['grade'] == $grade->id): ?> SELECTED <?php endif; ?> <?php endif; ?> value="<?php echo e($grade->id); ?>"><?php echo e($grade->name); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
						<?php endif; ?>
					</select>
				</div>
					<div class="filter_input">
					<label>Student</label>
					<select name="student" class="form-control students_appended">
						<option value="">All Students</option>
						<?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
						   <option <?php if(isset($_GET['student'])): ?> <?php if($_GET['student'] == $student->id): ?> SELECTED <?php endif; ?> <?php endif; ?> value="<?php echo e($student->id); ?>"><?php echo e($student->name); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
						<?php endif; ?>
					</select>
				</div>


				<div class="filter_input">
						<label>Time Period</label>
						<select class="form-control select_duration" name="duration">
							<option selected value="D">Daily</option>
							<option <?php if(isset($_GET['duration']) && trim($_GET['duration']) == "W"): ?> SELECTED <?php endif; ?> value="W">Weekly</option>
							<option <?php if(isset($_GET['duration']) && trim($_GET['duration']) == "M"): ?> SELECTED <?php endif; ?> value="M">Monthly</option>
							<option <?php if(isset($_GET['duration']) && trim($_GET['duration']) == "Y"): ?> SELECTED <?php endif; ?> value="Y">Yearly</option>
							<option <?php if(isset($_GET['duration']) && trim($_GET['duration']) == "C"): ?> SELECTED <?php endif; ?> value="C">Custom</option>
						</select>
					</div>

					<div class="custom_filter_inputs filter_input <?php if(isset($_GET['duration']) && $_GET['duration'] == 'C'): ?> show_fields <?php else: ?> hide <?php endif; ?>">
						<div class="filter_input">
							<label>Start Date</label>
								<input placeholder="Start Date" id="start_datepicker" class="form-control custom_filter_inpt" name="from_date" value="<?php if(isset($_GET['from_date'])): ?><?php echo e(trim($_GET['from_date'])); ?><?php endif; ?>" autocomplete="off"  required/>
	      				</div>
          			</div>
          			<div class="custom_filter_inputs filter_input <?php if(isset($_GET['duration']) && $_GET['duration'] == 'C'): ?> show_fields <?php else: ?> hide <?php endif; ?>">
          				<div class="filter_input">
							<label>End Date</label>
							<input placeholder="End Date" id="end_datepicker" class="form-control custom_filter_inpt" name="to_date" value="<?php if(isset($_GET['to_date'])): ?><?php echo e(trim($_GET['to_date'])); ?><?php endif; ?>" autocomplete="off"  required />
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
				<?php
					$urlQuery="";
					if(isset($_GET['grade']) && !empty($_GET['grade'])){
						$urlQuery .= "grade=".$_GET['grade'];
					}
					if(isset($_GET['student']) && !empty($_GET['student'])){
						$urlQuery .= "&student=".$_GET['student'];
					}
				?>
				<div class="grade_listng bottm_grph analytc_sctn">
	  			<div> <h4>Reports</h4>
					<!-- <div class="daily_wekly">
						<ul >
							<li class="li_daily <?php if(isset($_GET['filter']) && $_GET['filter'] == 'D'): ?>active <?php endif; ?>"><a href="<?php echo e(URL::to('/')); ?>/analytics?filter=D&<?php echo e($urlQuery); ?>">Daily</a></li>
							<li class="<?php if(isset($_GET['filter']) && $_GET['filter'] == 'W'): ?>active <?php endif; ?>"><a href="<?php echo e(URL::to('/')); ?>/analytics?filter=W&<?php echo e($urlQuery); ?>">Weekly</a></li>
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
	  <h4>Behavior</h4>
				  
 <div id="container3" style="height: 350px"></div>
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
				<li>
					<div class="grade_listng bottm_grph othr_beh_loc">
			  		<h4>Location</h4>
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
			<li>
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
	<div class="note_sction hide">
		<h4>Notes</h4>
		<P>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words
which don't look even slightly believable. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by
injected humour, or randomised words which don't look even slightly believable.</p>
	</div>
</div>
	
<div class="col-md-12 text-center">
	<div class="btn_downld">
		<button data-toggle="modal" data-target="#chnge_pswd" class="btn btn-link download-pdf1 add_notes_pdf"><img src="<?php echo e(URL::to('/')); ?>/public/images/download.png">DOWNLOAD PDF REPORT</button>
		<!-- <button class="btn btn-link download-pdf1"><img src="<?php echo e(URl::to('/')); ?>/public/images/download.png">DOWNLOAD PDF REPORT</button> -->
	</div>
</div>

</section>


<section class="footer_inner">
<!-- footer section start -->
	<p>&copy; Copyright 2019. All Rights Reserved.</p>
<!-- footer section end -->
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/7.1.2/modules/exporting.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/public/js/custom.js"></script>

<?php
	$timePerios = "'" . implode ( "', '", array_map(function ($entry) {
	  return $entry['time'];
	}, $timeChart) ) . "'";

	$timeReports =  implode(', ', array_map(function ($entry) {
	  return $entry['reports'];
	}, $timeChart));
?>
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
	categories:[<?php echo $timePerios; ?>]

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
	data: [<?php echo e($timeReports); ?>],

    showInLegend: false
  }]

});

</script>
<?php
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
?>
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
        data: [<?php echo e($selfAwarenessMale); ?>, <?php echo e($selfManagementMale); ?>, <?php echo e($decisionMakingMale); ?>, <?php echo e($relationshipSkillsMale); ?>, <?php echo e($socialAwarenessMale); ?>],
		showInLegend: false
	}, {
	 name: 'Female',
       /* data: [1, 3, 2, 2, 1],*/
        data: [<?php echo e($selfAwarenessFemale); ?>, <?php echo e($selfManagementFemale); ?>, <?php echo e($decisionMakingFemale); ?>, <?php echo e($relationshipSkillsFemale); ?>, <?php echo e($socialAwarenessFemale); ?>],
		showInLegend: false,
        color: '#ce6ddd',
    }]

});
</script> 
<?php
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
?>
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
    data: [<?php echo e($selfAwareness); ?>, <?php echo e($selfManagement); ?>, <?php echo e($decisioMaking); ?>, <?php echo e($relationshipSkills); ?>, <?php echo e($socialAwareness); ?>],
    showInLegend: false
  }]

});

</script>
<?php
	$BehaviorShow = array('IN' => 0,'IL' => 0,'IC' => 0,'FI' => 0,'CD' => 0,'PI' =>0,'BU' =>0,'IA' =>0,'TT' =>0,'OT' =>0); 
	foreach($BehaviorShow as $key=>$value){
	 	if(array_search($key, array_column($Behavior, 'short_name')) !== false) {
	       $keyFind = array_search($key, array_column($Behavior, 'short_name'));
	       $BehaviorShow[$key] = $Behavior[$keyFind]->behaviors_count;
		}
	}
	$allBehabiours = implode(",",$BehaviorShow);
?>
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
    data: [<?php echo e($allBehabiours); ?>],
    showInLegend: false
  }]

});   

</script>
<?php
	$LocationsShow = array('CL' => 0,'PL' => 0,'CA' => 0,'GY' => 0,'HA' => 0,'COA' =>0,'BA' =>0,'LI' =>0,'BU' =>0,'OT' =>0); 
	if(!empty($LocationsShow)){
		foreach($LocationsShow as $key=>$value){
		 	if(array_search($key, array_column($locations, 'short_name')) !== false) {
		       $keyFind = array_search($key, array_column($locations, 'short_name'));
		       $LocationsShow[$key] = $locations[$keyFind]->locations_count;
			}
		}
	}
	$allLocations = implode(",",$LocationsShow);
?> 
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
    categories: ['CL', 'PL', 'CA', 'GY', 'HA', 'COA', 'BA', 'LI', 'BU', 'OT' ]
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
    data: [<?php echo e($allLocations); ?>],
    showInLegend: false
  }]

});
</script>
<?php
	$InterventionssShow = array('RPO' => 0,'LD' => 0,'ASD' => 0,'IS' => 0,'ES' => 0,'OT' =>0); 
	if(!empty($InterventionssShow)){
		foreach($InterventionssShow as $key=>$value){
		 	if(array_search($key, array_column($Interventions, 'short_name')) !== false) {
		       $keyFind = array_search($key, array_column($Interventions, 'short_name'));
		       $InterventionssShow[$key] = $Interventions[$keyFind]->interventions_count;
			}
		}
	}
	$allInterventions = implode(",",$InterventionssShow);
?>
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
    categories: ['RPO', 'LD', 'ASD', 'IS', 'ES', 'OT' ]
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
    data: [<?php echo e($allInterventions); ?>],
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
	     <?php if(!isset($_GET['from_date']) && empty($_GET['from_date'])): ?>
    		useCurrent:true,
    		<?php else: ?> 
    		useCurrent:false,
    	<?php endif; ?>
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
    <?php if(!isset($_GET['to_date']) && empty($_GET['to_date'])): ?>
    	useCurrent:true,
    	<?php else: ?> 
    	useCurrent:false,
    <?php endif; ?>
    
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
<?php if(!isset($_GET['from_date']) && empty($_GET['from_date'])): ?>
<script>
//$("#start_datepicker").val('');
</script>
<?php endif; ?>
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


<?php /**PATH /var/www/html/restore/resources/views/School/analytics.blade.php ENDPATH**/ ?>