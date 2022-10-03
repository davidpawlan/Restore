<!DOCTYPE html>
<html lang="en">
<head>
  <title>Restore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/style.css">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/custom.css">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/bootstrap-slider.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel='stylesheet' href='<?php echo e(URL::to('/')); ?>/public/css/bootstrap-datetimepicker.min.css'>
  <script src="<?php echo e(URL::to('/')); ?>/public/js/jquery.min.js"></script>
  <script src="<?php echo e(URL::to('/')); ?>/public/js/bootstrap.min.js"></script>
  <script src="<?php echo e(URL::to('/')); ?>/public/js/bootstrap-slider.min.js"></script>
  <script src="<?php echo e(URL::to('/')); ?>/public/js/moment.min.js"></script>
  <script src="<?php echo e(URL::to('/')); ?>/public/js/bootstrap-datetimepicker.min.js"></script>
</head>
<body>
<!--Include Header-->
<?php echo $__env->make("Elements.school_header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 
<section class="rport_outer">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="report_inner">
				<h3>Student</h3>
				<?php if(Session::has('success')): ?>
					<p class="text-center"><label class="success"><?php echo e(Session::get('success')); ?></label></p>
				<?php endif; ?>
				<?php if(Session::has('error')): ?>
					<p class="text-center"><label class="error"><?php echo e(Session::get('error')); ?></label></p>
				<?php endif; ?>

				<form method="POST" action="<?php echo e(URL::to('/')); ?>/reports" class="validate_report_form">
				<?php echo csrf_field(); ?>
				<div class="row form-group">
					<div class="col-md-12">
						<label>Grade</label>
						<select class="form-control" id="grade_select" name="grade_id" required>
							<option value="">Select Grade</option>
							<?php $__empty_1 = true; $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
							  <option <?php if(isset($_GET['grade'])): ?> <?php if($_GET['grade'] == $grade->id): ?> SELECTED <?php endif; ?> <?php endif; ?> value="<?php echo e($grade->id); ?>"><?php echo e($grade->name); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
							<?php endif; ?>
						  </select>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-6 mrgn_btm">
						<label>Student</label>
						<select class="form-control" name="student_id" id="grade_students" required>
							<!--Student list on change grade_select in custom.js-->
							<option value="">Select Student</option>
							<?php if(isset($students) && !empty($students)): ?>
							  <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
									<option <?php if(isset($_GET['student'])): ?> <?php if(base64_decode($_GET['student']) == $student->id): ?> selected <?php endif; ?> <?php endif; ?> value="<?php echo e($student->id); ?>"><?php echo e($student->name); ?></option>
							   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
							  <?php endif; ?>
							<?php endif; ?>
						</select>
					</div>
					<div class="col-md-6">
						<label>Gender</label>
						<select class="form-control" name="gender" id="gender_select" required>
							<option value="">Select Gender</option>
							<option value="M">Male</option>
							<option value="F">Female</option>
						  </select>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label>Behavior</label>
							<select class="form-control" name="behaviour_id" required>
								<option value="">Select Behavior</option>
								<?php $__empty_1 = true; $__currentLoopData = $behaviours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $behaviour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
								<option value="<?php echo e($behaviour->id); ?>"><?php echo e($behaviour->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
								<?php endif; ?>
						   </select>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label for="pwd">Location</label>
							<select class="form-control" name="location_id" required>
								<option value="">Select Location</option>
								<?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
								  <option value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
								<?php endif; ?>
							</select>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-6 mrgn_btm">
						<label>Date</label>
						<div class="input-group date" id="datepicker">
            				<input placeholder="Select date" class="form-control" name="date" required/><span class="input-group-append input-group-addon"><span class="input-group-text"><img src="<?php echo e(URL::to('/')); ?>/public/images/date.png"></span></span>
          				</div>
          <span class="date_error hide"></span>
					</div>
					<div class="col-md-6">
						<label>Time</label>
					
               <div class="input-group time" id="timepicker">
            <input placeholder="Select Time" class="form-control" name="time" required/><span class="input-group-append input-group-addon"><span class="input-group-text"><img src="<?php echo e(URL::to('/')); ?>/public/images/time.png"></span></span>
          </div>
          <span class="time_error hide"></span>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label>Intervention</label>
							<select class="form-control" name="intervention_id" required>
								<option value="">Select Intervention</option>
								<?php $__empty_1 = true; $__currentLoopData = $interventions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intervention): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
								    <option value="<?php echo e($intervention->id); ?>"><?php echo e($intervention->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
								<?php endif; ?>
							</select>
					</div>
				</div>
				<div class="other_fiels">
					<h3>Restorative Practice</h3>
					<div class="row form-group">
					<div class="col-md-6 mrgn_btm">
						<label>Self Awareness:</label>
						<div class="slidr_fild">
						 <input name="self_awareness" id="ex21" type="text"
          data-provide="slider"
          data-slider-ticks="[1, 2, 3]"
          data-slider-ticks-labels='["Poor", "Average", "Optimal"]'
          data-slider-min="1"
          data-slider-max="3"
          data-slider-step="1"
          data-slider-value="3"
          data-slider-tooltip="hide" />
		  </div>
					</div>
					<div class="col-md-6">
						<label>Self Management:</label>
							<div   class="slidr_fild">
						 <input name="self_management" id="ex22" type="text"
          data-provide="slider"
          data-slider-ticks="[1, 2, 3]"
          data-slider-ticks-labels='["Poor", "Average", "Optimal"]'
          data-slider-min="1"
          data-slider-max="3"
          data-slider-step="1"
          data-slider-value="3"
          data-slider-tooltip="hide" />
		  </div>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-6 mrgn_btm">
						<label>Responsible Decision Making:</label>
						<div class="slidr_fild">
						 <input  name="responsible_dec_make" id="ex23" type="text"
          data-provide="slider"
          data-slider-ticks="[1, 2, 3]"
          data-slider-ticks-labels='["Poor", "Average", "Optimal"]'
          data-slider-min="1"
          data-slider-max="3"
          data-slider-step="1"
          data-slider-value="3"
          data-slider-tooltip="hide" />
		  </div>
					</div>
					<div class="col-md-6">
						<label>Relationship Skills:</label>
						<div class="slidr_fild">
						 <input name="relationship_skills" id="ex24" type="text"
          data-provide="slider"
          data-slider-ticks="[1, 2, 3]"
          data-slider-ticks-labels='["Poor", "Average", "Optimal"]'
          data-slider-min="1"
          data-slider-max="3"
          data-slider-step="1"
          data-slider-value="3"
          data-slider-tooltip="hide" />
		  </div>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-6 mrgn_btm">
						<label>Social Awareness</label>
							<div class="slidr_fild">
						 <input name="social_awareness" id="ex25" type="text"
          data-provide="slider"
          data-slider-ticks="[1, 2, 3]"
          data-slider-ticks-labels='["Poor", "Average", "Optimal"]'
          data-slider-min="1"
          data-slider-max="3"
          data-slider-step="1"
          data-slider-value="3"
          data-slider-tooltip="hide" />
		  </div>
					</div>
				</div>
				
				<div class="row form-group">
					<div class="col-md-12">
						<label>Notes</label>
							<textarea name="notes" class="form-control" placeholder="Enter Notes"/></textarea>
					</div>
				</div>
				
				<div class="row text-center">
					<div class="col-md-12 btn_submit">
						<button type="submit" class="btn btn-link">Submit</button>
					</div>
				</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="footer_inner">
<!-- footer section start -->
	<p>&copy; Copyright 2019. All Rights Reserved.</p>
<!-- footer section end -->
</section>


<script type="text/javascript">
/*	if (/Mobi/.test(navigator.userAgent)) {
  // if mobile device, use native pickers
  $(".date input").attr("type", "date");
  $(".time input").attr("type", "time");
} else {*/
  // if desktop device, use DateTimePicker
  $("#datepicker").datetimepicker({
    /*useCurrent: false,*/
    format: "ll",
    maxDate: moment(),
    icons: {
      next: "fa fa-chevron-right",
      previous: "fa fa-chevron-left"
    }
  });
  $("#timepicker").datetimepicker({
    format: "hh:mm A",
   	minDate: moment({h:7,m:00}),
    maxDate: moment({h:16,m:59}),
    useCurrent: false,
    icons: {
      up: "fa fa-chevron-up",
      down: "fa fa-chevron-down"
    }
  });

/*}*/
</script>
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/public/js/custom.js"></script>
</body>
</html><?php /**PATH /var/www/html/restore/resources/views/School/reports_form.blade.php ENDPATH**/ ?>