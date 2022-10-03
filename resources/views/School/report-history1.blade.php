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
	  <div class="col-md-12">
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
			<div class="filter_input">
				<label>Grade</label>
				<select class="form-control">
				<option>Select Grade</option>
							<option>Kindergarten</option>
							<option>1st grade</option>
							<option>2nd grade</option>
							<option>3rd grade</option>
							<option>4th grade</option>
							<option>5th grade</option>
							<option>6th grade</option>
							<option>7th grade</option>
							<option>8th grade</option>
						  </select>
			</div>
				<div class="filter_input">
				<label>Student</label>
				<select class="form-control">
								<option>Select Student</option>
							<option>Harry</option>
							<option>John</option>
							<option>Marry</option>
							<option>Joshef</option>
						  </select>
			</div>
			<div class="filter_btn">
				<button class="btn btn-link">Submit</button>
			</div>
		</div>
	  </div>

	  <div class="col-md-12">
		<div class="tabl_grade">
			<div class="grde_hedg">
				<ul>
					<li><h4>Last few reports</h4></li>
					
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
							<th>Notes</th>
							<th>Action</th>
						  </tr>
						</thead>
							<tbody>
							  <tr>
								<td>1291</td>
								<td>Kindergarten</td>
								<td>Christain Brown</td>
								<td>4/6/2019 & 10:00 AM</td>
								<td>It is a long established fact that a reader will be </br> distracted by the readable content of a page.</td>
								<td><button class="btn btn-link" data-toggle="modal" data-target="#view">View</button>
							  </tr>
							   <tr>
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
							  </tr>
					</tbody>
					</table>
				</div>
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
        <div class="modal-body">
			
			<div class="row">
               <div class="col-sm-7">
                    <h4>Report ID:</h4>
               </div>
               <div class="col-sm-5">
                   <p>1291</p>
               </div>
			</div>	
			<div class="row">
               <div class="col-sm-7">
                    <h4>Grade:</h4>
               </div>
               <div class="col-sm-5">
                   <p>Kindergarten</p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Student Name:</h4>
               </div>
               <div class="col-sm-5">
                   <p>Christain Brown</p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Gender:</h4>
               </div>
               <div class="col-sm-5">
                   <p>Male</p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Date:</h4>
               </div>
               <div class="col-sm-5">
                   <p>4/6/19</p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Time:</h4>
               </div>
               <div class="col-sm-5">
                   <p>10:00 AM</p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Behavior:</h4>
               </div>
               <div class="col-sm-5">
                   <p>Inappropriate Language</p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Location:</h4>
               </div>
               <div class="col-sm-5">
                   <p>Playground</p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Intervention:</h4>
               </div>
               <div class="col-sm-5">
                   <p>Lunch Detention</p>
               </div>
			</div>

			<div class="row">
               <div class="col-sm-12 Practice">
                    <h3>Restorative Practice</h3>
               </div>
             
			</div>

			<div class="row">
               <div class="col-sm-7">
                    <h4>Self Awareness:</h4>
               </div>
               <div class="col-sm-5">
                   <p>Average</p>
               </div>
			</div>

			<div class="row">
               <div class="col-sm-7">
                    <h4>Self Management:</h4>
               </div>
               <div class="col-sm-5">
                   <p>Poor</p>
               </div>
			</div>

			<div class="row">
               <div class="col-sm-7">
                    <h4>Responsible Decision Making:</h4>
               </div>
               <div class="col-sm-5">
                   <p>Optimal</p>
               </div>
			</div>

			<div class="row">
               <div class="col-sm-7">
                    <h4>Relationship Skills:</h4>
               </div>
               <div class="col-sm-5">
                   <p>Average</p>
               </div>
			</div>

			<div class="row">
               <div class="col-sm-7">
                    <h4>Social Awareness:</h4>
               </div>
               <div class="col-sm-5">
                   <p>Poor</p>
               </div>
			</div>

			<div class="row">
               <div class="col-sm-12">
                    <h4>Notes</h4>
                    <p>It is a long established fact that a reader will be distracted by
the readable content of a page when looking at its layout.</p>
               </div>
              
			</div>
			</div>
      </div>
    </div>
  </div>

  @include("Elements.school_footer")


</body>
</html>