<!DOCTYPE html>
<html lang="en">
<head>
  <title>Report History - Restore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/style.css">
 <!--  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/reporthistory.css"> -->
<!--   <link rel="stylesheet" href="{{URL::to('/')}}/public/css/highcharts.css"> -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{URL::to('/')}}/public/js/jquery.min.js"></script>
   <script src="{{URL::to('/')}}/public/js/bootstrap.min.js"></script>
  <!--<script src="js/highcharts.js"></script>-->
<!-- <script src="js/highcharts-more.js"></script> -->
<!-- <script src="js/draggable-points.js"></script> -->
</head>
<body>

@include("Elements.school_header")

<section class="inner_home anylytc_home">
	<form method="GET" action="{{URL::to('/')}}/report-history" >
	  <div class="col-md-12">
	  	<form class="filter_resilts">
		<div class="top_filter">
				<h4>Filter By:</h4>
			<div class="filter_input">
				<select class="select_schools hide" name="school">
					<option value="{{Auth::id()}}" selected>{{Auth::id()}}</option>
		    	</select>
				<label>Grade</label>
				@php
					$class="";
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
			    </select>
			</div>
			<div class="filter_btn">
				<button class="btn btn-link">Submit</button>
			</div>
		</div>
		</form>
	  </div>
	

	  <div class="col-md-12">
		<div class="tabl_grade">
			<div class="grde_hedg">
				<ul>
					@if($pagination != "TRUE")
					<li><h4>Last few reports</h4></li>
					@endif
				</ul>
			</div>
			<div class="table-responsive">
				<table class="table">
					<thead>
						  <tr>
							<th>ID</th>
							<th>Grade</th>
							<th>Student Name</th>
							<th>Date & Time</th>
							<th class="">Notes</th>
							<th>Action</th>
						  </tr>
						</thead>
							<tbody>
								@forelse($getGradeHistory as $history)
								  	<tr>
										<td>{{$history['id']}}</td>
										<td>{{$history['grade']['name']}}</td>
										<td>@if(!empty($history['student']['name'])){{$history['student']['name']}} @else {{$history['student_namee']}} @endif</td>
										<td>{{date("m/d/Y",strtotime($history['date']))}} & {{date("h:i A",strtotime($history['time']))}}</td>
										@if(!empty($history['other_notes']))
											@php
												if(strlen($history['other_notes']) > 100){
													$notes = substr($history['other_notes'], 0, 100)." ...";
												}else{
													$notes = $history['other_notes'];
												}
											@endphp
											<td class="">{{$notes}}</td>
										@else
											 <td class="">Not added</td>
										@endif
										<!-- <td><button class="btn btn-link" data-toggle="modal" data-target="#view">View</button> -->
										<td><button class="btn btn-link view_report_btn" data-id="{{$history['id']}}">View</button>
							  		</tr>
								 @empty
								 <tr><td class="text-center" colspan="6">No report found</td></tr>
								 @endforelse
							
							 <!--   <tr>
								<td>1826</td>
								<td>4th grade</td>
								<td>Cally Mores</td>
								<td>25/5/2019 & 11:00 AM</td>
								<td>It is a long established fact that a reader will be </br> distracted by the readable content of a page.</td>
								<td><button class="btn btn-link" data-toggle="modal" data-target="#view">View</button>
							  </tr>
							   <tr>
								<td>756</td>
								<td>7th grade</td>
								<td>Aahron Shah</td>
								<td>22/5/2019 & 12:10 PM</td>
								<td>It is a long established fact that a reader will be </br> distracted by the readable content of a page.</td>
								<td><button class="btn btn-link" data-toggle="modal" data-target="#view">View</button>
							  </tr>
							   <tr>
								<td>934</td>
								<td>2nd grade</td>
								<td>Baylee Sherlen</td>
								<td>10/4/2019 & 01:15 PM</td>
								<td>It is a long established fact that a reader will be </br> distracted by the readable content of a page.</td>
								<td><button class="btn btn-link" data-toggle="modal" data-target="#view">View</button>
							  </tr>

							   <tr>
									<td>123</td>
									<td>2nd grade</td>
									<td>Abbie Thomas</td>
									<td>10/4/2019 & 01:11 PM</td>
									<td>It is a long established fact that a reader will be </br> distracted by the readable content of a page.</td>
									<td><button class="btn btn-link" data-toggle="modal" data-target="#view">View</button>
						      		</td>
							  </tr> -->
					</tbody>
					</table>
				</div>
				@if($pagination == "TRUE")
				<div class="pagination_lins text-cenetr">
					{{$getGradeHistory->appends($_GET)->links()}}
				</div>
				@endif
			</div>
		</div>
	

</section>

<div class="modal fade" id="view" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content report_inner">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="{{URL::to('/')}}/public/images/close.png"></button>
          <h4 class="modal-title">Report View</h4>
        </div>
     	<div class="modal-body report-details-show">
     	</div>
      </div>
    </div>
  </div>

  @include("Elements.school_footer")

 <script src="{{URL::to('/')}}/public/js/custom.js"></script>
</body>
</html>