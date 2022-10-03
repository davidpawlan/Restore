      <div class="row">
               <div class="col-sm-7">
                    <h4>Report ID:</h4>
               </div>
               <div class="col-sm-5">
                   <p><?php echo e($report['id']); ?></p>
               </div>
			</div>	
			<div class="row">
               <div class="col-sm-7">
                    <h4>Grade:</h4>
               </div>
               <div class="col-sm-5">
                   <p><?php echo e($report['grade']['name']); ?></p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Student Name:</h4>
               </div>
               <div class="col-sm-5">
                    <p><?php echo e($report['student']['name']); ?></p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                 <h4>Gender:</h4>
               </div>
               <div class="col-sm-5">
                <?php if($report['gender'] == "M"): ?>
                  <p>Male</p>
                <?php else: ?>
                  <p>Female</p>
                <?php endif; ?>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Date:</h4>
               </div>
               <div class="col-sm-5">
                   <p><?php echo e(date("d/m/Y",strtotime($report['date']))); ?></p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Time:</h4>
               </div>
               <div class="col-sm-5">
                   <p><?php echo e(date("h:i A",strtotime($report['time']))); ?></p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Behavior:</h4>
               </div>
               <div class="col-sm-5">
                   <p><?php echo e($report['behaviour']['name']); ?></p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Location:</h4>
               </div>
               <div class="col-sm-5">
                   <p><?php echo e($report['location']['name']); ?></p>
               </div>
			</div>
			<div class="row">
               <div class="col-sm-7">
                    <h4>Intervention:</h4>
               </div>
               <div class="col-sm-5">
                   <p><?php echo e($report['intervention']['name']); ?></p>
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
                  <?php if($report['intervention'] == 1): ?>
                   <p>Poor</p>
                    <?php elseif($report['intervention'] == 2): ?>
                   <p>Average</p>
                     <?php else: ?>
                   <p>Optimal</p>
                   <?php endif; ?>
               </div>
			</div>

			<div class="row">
               <div class="col-sm-7">
                    <h4>Self Management:</h4>
               </div>
               <div class="col-sm-5">
                   <?php if($report['self_management'] == 1): ?>
                   <p>Poor</p>
                    <?php elseif($report['self_management'] == 2): ?>
                   <p>Average</p>
                     <?php else: ?>
                   <p>Optimal</p>
                   <?php endif; ?>
               </div>
			</div>

			<div class="row">
               <div class="col-sm-7">
                    <h4>Responsible Decision Making:</h4>
               </div>
               <div class="col-sm-5">
                    <?php if($report['responsible_decision_making'] == 1): ?>
                   <p>Poor</p>
                    <?php elseif($report['responsible_decision_making'] == 2): ?>
                   <p>Average</p>
                     <?php else: ?>
                   <p>Optimal</p>
                   <?php endif; ?>
               </div>
			</div>

			<div class="row">
               <div class="col-sm-7">
                    <h4>Relationship Skills:</h4>
               </div>
               <div class="col-sm-5">
                     <?php if($report['relationship_skills'] == 1): ?>
                   <p>Poor</p>
                    <?php elseif($report['relationship_skills'] == 2): ?>
                   <p>Average</p>
                     <?php else: ?>
                   <p>Optimal</p>
                   <?php endif; ?>
               </div>
			</div>

			<div class="row">
               <div class="col-sm-7">
                    <h4>Social Awareness:</h4>
               </div>
               <div class="col-sm-5">
                  <?php if($report['social_awareness'] == 1): ?>
                   <p>Poor</p>
                    <?php elseif($report['social_awareness'] == 2): ?>
                   <p>Average</p>
                     <?php else: ?>
                   <p>Optimal</p>
                  <?php endif; ?>
               </div>
			</div>

			<div class="row hide">
               <div class="col-sm-12">
                    <h4>Notes</h4>
                    <?php if(!empty($report['other_notes'])): ?>
                      <p><?php echo e($report['other_notes']); ?></p>
                    <?php else: ?>
                      <p>Not added</p>
                    <?php endif; ?>
               </div>
      </div><?php /**PATH /var/www/html/restore/resources/views/Render/report_details.blade.php ENDPATH**/ ?>