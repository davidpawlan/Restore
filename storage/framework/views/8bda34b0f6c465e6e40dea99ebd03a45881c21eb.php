<script>
base_url = "<?php echo e(URL::to('/')); ?>";
var today = "<?php echo e(date('M d, Y')); ?>";
</script>
<input type="hidden" class="csrf_token" value="<?php echo e(csrf_token()); ?>" />
<section class="header">
	<nav class="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="<?php echo e(URL::to('/')); ?>/admin/analytics"><img src="<?php echo e(URL::to('/')); ?>/public/images/logo_white.png"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="<?php echo e(Request::is('admin/analytics') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('/')); ?>/admin/analytics"><i class="fa fa-bar-chart" aria-hidden="true"></i> Analytics</a></li>
        <li class="<?php echo e(Request::is('admin/schools') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('/')); ?>/admin/schools"><i class="fa fa-university" aria-hidden="true"></i>  Schools Management</a></li>
        <li class="<?php echo e(Request::is('admin/report-history') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('/')); ?>/admin/report-history"><i class="fa fa-clock-o" aria-hidden="true"></i>Report History</a></li>
      </ul>
  </div>
	<div class="profile_info">
    <?php
      $profilePic = Auth::guard("admin")->user()->profile_pic; 
    ?>
					<ul>
             <?php if(empty($profilePic)): ?>
						  <Li><a href="<?php echo e(URL::to('/')); ?>/admin/settings"><p><?php echo substr(Auth::guard("admin")->user()->name,0,1); ?></p></a></li>
						 <?php else: ?>
              <Li><a href="<?php echo e(URL::to('/')); ?>/admin/settings"><p><img style="width:30px;height:30px;border-radius:100%" class="img_header" src="<?php echo e(URL::to('/')); ?>/public/uploads/profile_pic/<?php echo e($profilePic); ?>"></p></a></li>
             <?php endif; ?>
            <li><h5><?php echo e(Auth::guard("admin")->user()->name); ?></h5><h6><a href="<?php echo e(URL::to('/')); ?>/admin/logout">Logout</a></h6></li>
					</ul>
				</div>
  </div>
</nav>
</section><?php /**PATH /var/www/html/restore/resources/views/Elements/admin_header.blade.php ENDPATH**/ ?>