<!DOCTYPE html>
<html lang="en">
<head>
  <title>Report History - Restore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/style.css">
 <!--  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/reporthistory.css"> -->
<!--   <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/highcharts.css"> -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?php echo e(URL::to('/')); ?>/public/js/jquery.min.js"></script>
   <script src="<?php echo e(URL::to('/')); ?>/public/js/bootstrap.min.js"></script>
  <!--<script src="js/highcharts.js"></script>-->
<!-- <script src="js/highcharts-more.js"></script> -->
<!-- <script src="js/draggable-points.js"></script> -->
</head>
<body>
<!--Include Header-->
	<?php echo $__env->make("Elements.admin_header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<section class="inner_home anylytc_home">
	  <div class="col-md-12">
	  	<form class="filter_resilts">
		<div class="top_filter">
				<h4>Filter By:</h4>
			<div class="filter_input">
						<label>School</label>
						<?php
							$class="hide";
							if(isset($_GET['school']) && !empty(trim($_GET['school']))){
								$class="";
							}
						?>
						<select class="form-control select_schools" name="school">
							<option  value="">All Schools</option>
							<?php $__empty_1 = true; $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
								<option <?php if(isset($_GET['school'])): ?> <?php if($_GET['school'] == $school->id): ?> selected <?php endif; ?> <?php endif; ?> value="<?php echo e($school->id); ?>"><?php echo e($school->name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
							<?php endif; ?>
						</select> 

			</div>
			<div class="filter_input">
				<label>Grade</label>
				<select class="form-control select_grade" name="grade">
						<option value="" id="select_grades_option">All Grades</option>
						<?php $__empty_1 = true; $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
								<option <?php if(isset($_GET['grade'])): ?> <?php if(trim($_GET['grade']) == $grade->id): ?> selected <?php endif; ?> <?php endif; ?> class="<?php echo e($class); ?>" value="<?php echo e($grade->id); ?>"><?php echo e($grade->name); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
						<?php endif; ?>

						<!-- <option>Kindergarten</option>
						<option>1st grade</option>
						<option>2nd grade</option>
						<option>3rd grade</option>
						<option>4th grade</option>
						<option>5th grade</option>
						<option>6th grade</option>
						<option>7th grade</option>
						<option>8th grade</option> -->
			    </select>
			</div>
			<div class="filter_input">
				<label>Student</label>
				<select class="form-control students_appended" name="student">
					<option value="">All Students</option>
					<!--if filter is set for school and grade then get the stdentd of that grade of school-->
					<?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                       <option <?php if(isset($_GET['student'])): ?> <?php if($_GET['student'] == $student->id): ?> selected <?php endif; ?> <?php endif; ?> value="<?php echo e($student->id); ?>"><?php echo e($student->name); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
					<?php endif; ?>
					<!--Append by ajax custom.js:-->
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
					<?php if($pagination != "TRUE"): ?>
					<li><h4>Last few reports</h4></li>
					<?php endif; ?>
				</ul>
			</div>
			
			<div class="table-responsive">
				<table class="table">
					<thead>
						  <tr>
							<th>ID</th>
							<th>School Name</th>
							<th>Grade</th>
							<th>Student Name</th>
							<th>Date & Time</th>
							<th class="hide">Notes</th>
							<th>Action</th>
						  </tr>
						</thead>

							<tbody>
								<?php $__empty_1 = true; $__currentLoopData = $getGradeHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
								<tr>
										<td><?php echo e($history['id']); ?></td>
										<td><?php echo e($history['school']['name']); ?></td>
										<td><?php echo e($history['grade']['name']); ?></td>
										<td><?php echo e($history['student']['name']); ?></td>
										<td><?php echo e(date("d/m/Y",strtotime($history['date']))); ?> & <?php echo e(date("h:i A",strtotime($history['time']))); ?></td>
										<?php if(!empty($history['other_notes'])): ?>
											<?php
												if(strlen($history['other_notes']) > 100){
													$notes = substr($history['other_notes'], 0, 100)." ...";
												}else{
													$notes = $history['other_notes'];
												}
											?>
											<td class="hide"><?php echo e($notes); ?></td>
											<?php else: ?>
											 <td class="hide">Not added</td>
											<?php endif; ?>
										<!-- <td><button class="btn btn-link" data-toggle="modal" data-target="#view">View</button> -->
										<td><button class="btn btn-link view_report_btn" data-id="<?php echo e($history['id']); ?>">View</button>
							  		</tr>
								 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
								 <tr><td class="text-center" colspan="6">No report found</td></tr>
								 <?php endif; ?>
							
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
				<?php if($pagination == "TRUE"): ?>
				<div class="pagination_lins text-cenetr">
					<?php echo e($getGradeHistory->appends($_GET)->links()); ?>

				</div>
				<?php endif; ?>
			</div>
		</div>
	

</section>

<div class="modal fade" id="view" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content report_inner">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="<?php echo e(URL::to('/')); ?>/public/images/close.png"></button>
          <h4 class="modal-title">Report View</h4>
        </div>
     	<div class="modal-body report-details-show">
     	</div>
      </div>
    </div>
  </div>

  <?php echo $__env->make("Elements.school_footer", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?php echo e(URL::to('/')); ?>/public/js/custom.js"></script>
</body>
</html><?php /**PATH /var/www/html/restore/resources/views/Admin/report-history.blade.php ENDPATH**/ ?>