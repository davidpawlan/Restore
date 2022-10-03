<script>
base_url = "<?php echo e(URL::to('/')); ?>";
var today = "<?php echo e(date('M d, Y')); ?>";
</script>
<input type="hidden" class="csrf_token" value="<?php echo e(csrf_token()); ?>" />
<section class="header" id="myHeader">
  <nav class="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="<?php echo e(URL::to('/')); ?>"><img src="<?php echo e(URL::to('/')); ?>/public/images/logo_white.png"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="<?php echo e(Request::is('/') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('/')); ?>"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
        
        <li class="<?php echo e((Request::is('reports') ? 'active' : '')); ?>"><a href="<?php echo e(URL::to('/')); ?>/reports"><i class="fa fa-file-text-o" aria-hidden="true"></i> Report</a></li>
        
        <li class="<?php echo e(Request::is('analytics') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('/')); ?>/analytics"><i class="fa fa-bar-chart" aria-hidden="true"></i> Analytics</a></li>
        
        <li class="<?php echo e(Request::is('settings') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('/')); ?>/settings"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a></li>

        <li class="<?php echo e(Request::is('report-history') ? 'active' : ''); ?>"><a href="<?php echo e(URL::to('/')); ?>/report-history"><i class="fa fa-clock-o" aria-hidden="true"></i>Report History</a></li>
      </ul>
   </div>
  <div class="profile_info">
    <?php
      $userId = Auth::id();
      $getUserProfilePic = DB::table("schools")->where("user_id",$userId)->select("profile_image")->first();
      $profilePic = $getUserProfilePic->profile_image; 
    ?>

          <ul>
            <Li>
            <?php if(empty($profilePic)): ?>
              <a href="<?php echo e(URL::to('/')); ?>/settings"><p><?php echo substr(Auth::user()->name,0,1); ?></p></a>
               <?php else: ?>
              <a href="<?php echo e(URL::to('/')); ?>/settings"><p><img style="width:30px;height:30px;border-radius:100%" class="img_header" src="<?php echo e(URL::to('/')); ?>/public/uploads/profile_pic/<?php echo e($profilePic); ?>"></p></a>
                <?php endif; ?>

            </li>
            <li>
              <h5>
                <?php if(strlen(Auth::user()->name) > 10): ?>
                  <?php echo e(substr(Auth::user()->name,0,10)); ?> ...
                <?php else: ?>
                  <?php echo e(Auth::user()->name); ?>

                <?php endif; ?>
              </h5>

              <h6><a href="<?php echo e(URL::to('/')); ?>/logout">Logout</a></h6></li>
          </ul>
        </div>
  </div>
</nav>
</section><?php /**PATH /var/www/html/restore/resources/views/Elements/school_header.blade.php ENDPATH**/ ?>