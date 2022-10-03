<!DOCTYPE html>
<html lang="en">
<head>
  <title>School Management - Restore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo e(URL::to('/')); ?>/public/css/custom.css">
  <style>
  	section.header {
    	z-index: 999;
	}
	.rport_outer{
		min-height:900px;
	}
  </style>
</head>
<body>

<!--Include Header-->
<?php echo $__env->make("Elements.admin_header", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<section class="rport_outer">
			<div class="col-md-12">
		<div class="tabl_grade">
			<div class="grde_hedg">
				<ul>
					<li><h4>Schools Management</h4></li>
					<li><button type="button" class="btn btn-link" data-toggle="modal" data-target="#add_schools" style="text-decoration:underline">+ Add New School</button></li>
				</ul>
				<?php if(Session::has('success')): ?>
				<p class="alert <?php echo e(Session::get('alert-class', 'alert-success')); ?>"><?php echo e(Session::get('success')); ?></p>
				<?php endif; ?>
			</div>
			<div class="schl_tbl">
			<div class="table-responsive">
				<table class="table">
					<thead>
						  <tr>
							<th>#</th>
							<th>School Name</th>
							<th>Principal Name</th>
							<th>Email Address</th>
							<th>Password</th>
							<th>Action</th>
						  </tr>
						</thead>
							<tbody>
								<?php
									if(isset($_GET['page'])){
										$page = $_GET['page'];
										$page = $page-1;
									}else{
										$page = 0;
									}
									$paginationLimit = Config::get("constants.TABLE_LIMIT");
									$start = ($page*$paginationLimit)+1;
								?>

								<?php $__empty_1 = true; $__currentLoopData = $allSchools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

							  <tr>
								<td><?php echo e($start); ?></td>
								<td><?php echo e($school->name); ?></td>
								<td><?php echo e($school->school->principle_name); ?></td>
								<td><?php echo e($school->email); ?></td>
								<td><?php echo e($school->school->plain_password); ?></td>
								<td>
		<div class="dropdown dropdown_school">
  		<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select
		  <span class="caret"></span></button>
		  <ul class="dropdown-menu">
		    <li><a href="javascript:void(0)" data-school-id="<?php echo e($school->id); ?>" data-school-name="<?php echo e($school->name); ?>" data-principle-name="<?php echo e($school->school->principle_name); ?>" data-school-email="<?php echo e($school->email); ?>" data-toggle="modal"  class="edit_btn">Edit</a></li>
		    <li><a href="javascript:void(0);" data-button="Delete" data-title="Are you sure you want to delete this school?" data-href="<?php echo e(URL::to('/')); ?>/admin/schools/<?php echo e($school->id); ?>/delete" class="delete_btn">Delete</a></li>
		    <?php if($school->status == "1"): ?>
		    	<li><a href="javascript:void(0);" data-button="Dactivate" data-title="Are you sure to deactivate this school?" data-href="<?php echo e(URL::to('/')); ?>/admin/schools/<?php echo e($school->id); ?>/deactivate" class="delete_btn">Deactivate</a></li>
		  	<?php else: ?>
		  		<li><a href="javascript:void(0);" data-button="Activate" data-title="Are you sure to activate this school?" data-href="<?php echo e(URL::to('/')); ?>/admin/schools/<?php echo e($school->id); ?>/activate" class="delete_btn">Activate</a></li>
		  	<?php endif; ?>
		  </ul>
		</div>
								
								
								</td>
							  </tr>
							  <?php
							  	$start++;
							  ?>
							  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
							  <tr class="text-center"><td colspan="6">No Record Found</td></tr>
							  <?php endif; ?>
							
							<!--   <tr>
								<td>3</td>
								<td>Aukamm Elementary School</td>
								<td>James Smith</td>
								<td>aukamm_elementary@gmail.com</td>
								<td>J!%!81818</td>
								<td>
								<div class="dropdown dropdown_school">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="#">Edit</a></li>
    <li><a href="#">Delete</a></li>
    <li><a href="#">Deactivate</a></li>
  </ul>
</div>
								
								
								</td>
							  </tr> -->
							 <!--  <tr>
								<td>4</td>
								<td>Aukamm Elementary School</td>
								<td>James Smith</td>
								<td>aukamm_elementary@gmail.com</td>
								<td>J!%!81818</td>
							<td>
								<div class="dropdown dropdown_school">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="#">Edit</a></li>
    <li><a href="#">Delete</a></li>
    <li><a href="#">Deactivate</a></li>
  </ul>
</div>
								
								
								</td>
							  </tr> -->
							 
					</tbody>
					</table>
				</div>
			</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="pagintn_sctn">
				<?php
					$paginationLimit = Config::get("constants.TABLE_LIMIT");
					$records = ($paginationLimit*$page)+count($allSchools);
				?>
			<h4>Showing <?php echo e($records); ?> of <?php echo e($totalSchools); ?> entries</h4>
			<?php echo e($allSchools->links()); ?>

				 <!-- <ul class="pagination">
    <li><a href="#"><img src="<?php echo e(URL::to('/')); ?>/public/images/left_arrow.png"></a></li>
    <li><a href="#">1</a></li>
    <li class="active"><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
     <li><a href="#"><img src="<?php echo e(URL::to('/')); ?>/public/images/right_arrow.png"></a></li>
  </ul> -->
			</div>
		</div>
</section>


<div class="modal fade" id="add_schools" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content report_inner">
        <div class="modal-header">
          <button type="button" class="close close_icon_add_school " data-dismiss="modal"><img src="<?php echo e(URL::to('/')); ?>/public/images/close.png"></button>
          <h4 class="modal-title">Add New School</h4>
        </div>
        <form method="POST" class="add_school" id="add_school">
        <?php echo csrf_field(); ?>
	        <div class="modal-body">
				<div class="row form-group">
					<div class="col-md-12">
						<label>School Name</label>
						<input type="text" name="school_name" placeholder="Enter School Name" class="form-control letters_digits" autocomplete="off" maxlength="50" minlength="3" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label>Principal Name</label>
						<input type="text" name="principle_name" placeholder="Enter Principal Name" class="form-control only_letters"  pattern="[a-z]*" maxlength="50" minlength="3" autocomplete="off" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label>Email</label>
						<input type="email" name="school_email" placeholder="Enter Email Address" class="form-control space_disallow" id="email_school"  autocomplete="off" required>
						<label class="error email_exist_error"></label>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label>Password</label>
						<input type="password" style="display:none;" autocomplete="off" ><!--Used to remove prefilled email and password-->
						<input type="password" name="school_password"  placeholder="Enter Password" class="form-control space_disallow" id="pwd_school" maxlength="50" minlength="5" value="" autocomplete="off" required>
					</div>
				</div>
				<div class="row text-center submit_button_btn">
					<div class="col-md-12 btn_submit">
						<button class="btn btn-link submit_button_school">Submit <i class="fa fa-spinner fa-spin spinner_show hide" aria-hidden="true"></i></button>
					</div>
					<label class="error something_wrong_error"></label>
				</div>
	        </div>
    	</form>
      </div>
    </div>
  </div>



<!--Edit School-->
  <div class="modal fade" id="edit_school" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content report_inner">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="<?php echo e(URL::to('/')); ?>/public/images/close.png"></button>
          <h4 class="modal-title">Edit School</h4>
        </div>
        <form method="POST" class="editschool" id="editschool">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="school_id" class="edit_school_id" />
	        <div class="modal-body">
				<div class="row form-group">
					<div class="col-md-12">
						<label>School Name</label>
						<input type="text" name="school_name" placeholder="Enter School Name" class="form-control letters_digits edit_school_name" maxlength="50" minlength="3"  autocomplete="off" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label>Principal Name</label>
						<input type="text" name="principle_name" placeholder="Enter Principal Name" class="form-control only_letters edit_principle_name"  maxlength="50" minlength="3"  pattern="[a-z]*" autocomplete="off" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label>Email</label>
						<input type="email" name="school_email" placeholder="Enter Email Address" class="form-control space_disallow edit_school_email" id="email"  autocomplete="off" readonly required>
						<label class="error email_exist_error"></label>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label>Password</label>
						<input type="password" style="display:none;"><!--Used to remove prefilled email and password-->
						<input type="password" name="school_password"  placeholder="Enter Password" class="form-control space_disallow" id="pwd" minlength="5" autocomplete="off">
					</div>
				</div>
				<div class="row text-center submit_button_btn">
					<div class="col-md-12 btn_submit">
						<button type="submit" class="btn btn-link edit_button_school">Submit <i class="fa fa-spinner fa-spin spinner_show hide" aria-hidden="true"></i></button>
					</div>
					<label class="error something_wrong_error"></label>
				</div>
	        </div>
    	</form>
      </div>
    </div>
  </div>
  <!--Edit School-->
  
  
<?php echo $__env->make("Elements.admin_footer", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><span id="modal-header-titile"></span> School</h4>
      </div>
      <div class="modal-body">
        <p class="data-title">Are you sure about this ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="#" type="button" class="btn btn-danger" id="confirm_delete">Delete</a>
      </div>
    </div>
  </div>
</div>
</body>
<script src="<?php echo e(URL::to('/')); ?>/public/js/jquery.min.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/public/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="<?php echo e(URL::to('/')); ?>/public/js/custom.js"></script>
</html>


<?php /**PATH /var/www/html/restore/resources/views/Admin/schools.blade.php ENDPATH**/ ?>