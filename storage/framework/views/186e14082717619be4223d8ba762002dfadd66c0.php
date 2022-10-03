Hello <?php echo e($data['principle_name']); ?> ,
<p>Your account is created in RESTORE</p>
<p>Bellow are your login credentials</p>
<p>Email: <?php echo e($data['school_email']); ?></p>
<p>Password: <?php echo e($data['school_password']); ?></p>
<p><a href="<?php echo e(URL::to('/')); ?>/login">Click here to login</a></p><?php /**PATH /var/www/html/restore/resources/views/Emails/school-create.blade.php ENDPATH**/ ?>