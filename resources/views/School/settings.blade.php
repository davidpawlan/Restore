<!DOCTYPE html>
<html lang="en">
<head>
  <title>Settings - Restore</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/style.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/custom.css">
  <link rel="stylesheet" href="{{URL::to('/')}}/public/css/bootstrap-slider.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="{{URL::to('/')}}/public/js/jquery.min.js"></script>
  <script src="{{URL::to('/')}}/public/js/bootstrap.min.js"></script>
  <style>
  section.header {
    z-index: 999;
}
  </style>
</head>
<body>

<!--Include Header-->
@include("Elements.school_header")


<section class="rport_outer">
	<div class="col-md-12">
			<div class="tabl_grade prof_sctn">
			<div class="seettg_edt">
				<h4>Profile Information</h4>
				<button class="btn btn-link" data-toggle="modal" data-target="#chnge_pswd"><i class="fa fa-pencil"></i> Edit</button>
			</div>
				<div class="user_profl">
					<div class="user_img col-md-4">
						@php
					      $userId = Auth::id();
					      $getUserProfilePic = DB::table("schools")->where("user_id",$userId)->select("profile_image")->first();
					      $profilePic = $getUserProfilePic->profile_image; 
					    @endphp

						@if(isset($profilePic) && !empty($profilePic))
						  <p><img style="width:205px;height:205px;border-radius:100%" class="img_header" src="{{URL::to('/')}}/public/uploads/profile_pic/{{$profilePic}}"></p>
						@else
						  <p>@php echo strtoupper(substr(Auth::user()->name,0,1)); @endphp</p>
						@endif
						
						 <br/>
						<button  data-toggle="modal" data-target="#changeProfilePic" class="btn btn-primary center-block" style="background-color:#4479ff">Upload Profile Picture</button> 
					</div>
					<div class="user_info">
						<ul>

							<li><h5>School Name:</h5><p class="school_name_edit">{{$details['name']}}</p>&nbsp;<!--<i class="fa fa-pencil edit_school_info" data-title="Edit School Name" data-edit="school_name"  data-label="School Name" data-toggle="modal" data-target="#editSchoolInfo"></i>--></li>
							<li><h5>Principal Name:</h5><p class="principle_name_edit">{{$details['school']['principle_name']}}</p>&nbsp;<!--<i class="fa fa-pencil edit_school_info" data-title="Edit Principle Name" data-edit="principle_name" data-label="Principle Name" data-toggle="modal" data-target="#editSchoolInfo"></i>--></li>
							<li><h5>Password:</h5><p>{{"***********"}}</p></li>
						</ul>
					</div>
					<!--<div class="settng_button">
						<button class="btn btn-link" data-toggle="modal" data-target="#chnge_pswd">CHANGE PASSWORD</button>
					</div>-->
				</div>
			</div>
	</div>
	<div class="col-md-12">
		<div class="tabl_grade">
			<div class="grde_hedg">
				<ul>
					<li><h4>Grade Roster</h4></li>
					<li><button type="button" class="btn btn-link" data-toggle="modal" data-target="#upload_grade" style="text-decoration:underline">+ Upload Grade Roster</button> <br/> </li>
				</ul>
			</div>
			@if(Session::has('success'))
				<p class="text-center"><label class="success">{{ Session::get('success') }}</label></p>
			@endif
			@if(Session::has('error'))
							<p class="text-center"><label class="error">{{ Session::get('error') }}</label></p>
			@endif

			<div class="table-responsive">
				<table class="table">
					<thead>
						  <tr>
							<th>#</th>
							<th>Grade</th>
							<th>File Name</th>
							<th>Uploaded On</th>
							<th>Action</th>
						  </tr>
						</thead>
							<tbody>
								@forelse($grade_rosters as $key=>$rosters)
								
								  <tr>
									<td>{{$key+1}}</td>
									<td>{{@$rosters['grades']['name']}}</td>
									<td>{{$rosters['file_name']}}</td>
									<td>{{date("m/d/Y",strtotime($rosters['created_at']))}}</td>
									<td>
										<a href="javascript:void(0);" data-button="Delete" data-title="Are you sure to delete this grade roster? " data-href="{{URL::to('/')}}/delete-roster/{{$rosters->id}}" class="delete_btn btn btn-danger">DELETE</a>
										
										<!-- <select class="form-control" placeholder="Select"/>
											<option>Select</option>
											<option>Edit</option>
											<option>Delete</option>
											<option>Deactivate</option>
										</select> -->
									</td>
								  </tr>
								 @empty
								 <tr class="text-center">
								 	<td colspan="5">No data found</td>
								 </tr>
								 @endforelse
							 <!--   <tr>
								<td>2</td>
								<td>Kindergarten</td>
								<td>Jack_profile.csv</td>
								<td>4/6/2019</td>
								<td><select class="form-control" placeholder="Select"/><option>Select</option><option>Edit</option><option>Delete</option><option>Deactivate</option></select></td>
							  </tr>
							   <tr>
								<td>3</td>
								<td>7th grade</td>
								<td>Student_profile7.csv</td>
								<td>4/6/2019</td>
								<td><select class="form-control" placeholder="Select"/><option>Select</option><option>Edit</option><option>Delete</option><option>Deactivate</option></select></td>
							  </tr>
							   <tr>
								<td>4</td>
								<td>11th grade</td>
								<td>Lorem.csv</td>
								<td>4/6/2019</td>
								<td><select class="form-control" placeholder="Select"/><option>Select</option><option>Edit</option><option>Delete</option><option>Deactivate</option></select></td>
							  </tr> -->
					</tbody>
					</table>
				</div>
			</div>
		</div>
</section>

<div class="modal fade" id="upload_grade" role="dialog" style="padding-right: 0px;">
    <div class="modal-dialog modal-sm">
      <div class="modal-content report_inner">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="{{URL::to('/')}}/public/images/close.png"></button>
          <h4 class="modal-title">Upload Grade Roster</h4>
		</div>
        <form method="POST" class="validate_me" action="{{URL::to('/')}}/upload-grade-roaster" enctype="multipart/form-data">
        	@csrf
		        <div class="modal-body">
					<div class="row form-group">
							<div class="col-md-12">
								<label>Grade</label>
								<select class="form-control" name="grade" required>
									<option value="">Select Grade</option>
										@forelse($grades as $grade)
										<option value="{{$grade->id}}">{{$grade->name}}</option>
										@empty
										@endforelse
								  </select>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<label>Roster</label>
								
								<div class="custom-file-upload">
									<!--<label for="file">File: </label>--> 
									<input type="file" id="file" name="myfiles[]" accept=".csv" multiple/>
								</div>
							</div>

							<div class="col-md-12">
								<p class="dwnld_filefrmt">
									<a style="color: #4479ff;" 
							href="{{URL::to('/')}}/public/CSVs/students.csv" download> ( <i class="fa fa-download"> Sample Student CSV file</i> )</a>
								</p>
							</div>
						</div>
						
						<div class="row text-center">
							<div class="col-md-12 btn_submit">
								<button class="btn btn-link">Submit</button>
							</div>
						</div>
		        </div>
    	</form>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="chnge_pswd" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content report_inner">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="{{URL::to('/')}}/public/images/close.png"></button>
          <h4 class="modal-title">Edit Profile</h4>
        </div>
        <div class="modal-body">
			    <form method="POST" class="change_school_password">
			    	@csrf
			    	 <div class="row form-group">
						<div class="col-md-12">
							<label>School Name</label>
							<input type="text" name="school_name" 
							class="form-control prefile_text_input only_letters" 
							maxlength="50" minlength="3" value="{{$details['name']}}" placeholder="Enter School Name" required/>
						</div>
					</div>
					 <div class="row form-group">
						<div class="col-md-12">
							<label>Principal Name</label>
							<input type="text" name="principle_name" 
							class="form-control prefile_text_input only_letters" 
							maxlength="50" minlength="3"  value="{{$details['school']['principle_name']}}" placeholder="Enter Principal Name" required/>
						</div>
					</div>
				   <div class="row form-group">
						<div class="col-md-12">
							<label>Current Password</label>
							<input type="password" name="current_password" class="form-control space_disallow" placeholder="Enter Current Password" />
							<label class="current_password_error error hide"></label>
						</div>
					</div> 
					<div class="row form-group">
						<div class="col-md-12">
							<label>New Password</label>
							<input type="password" name="new_password" minlength="5" class="form-control space_disallow" placeholder="Enter New Password"/>
							<label class="new_password_error error hide"></label>
						</div>
						
					</div>
					
					<div class="row text-center">
						<div class="col-md-12 btn_submit">
							<label class="password_change_success success hide"></label>
							<button type="submit" class="btn btn-link btn-submit">Submit <i class="fa fa-spinner fa-spin spinner_show hide" aria-hidden="true"></i></button>
						</div>
					</div>
				</form>
        </div>
      </div>
    </div>
  </div>



<!-- Modal Dialog -->
<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title"><span id="modal-header-titile"></span> Roster</h4>
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



<!-- Modal -->
  <div class="modal fade" id="editSchoolInfo" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content report_inner">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="{{URL::to('/')}}/public/images/close.png"></button>
          <h4 class="modal-title school_edit_title">Edit School</h4>
        </div>
        <div class="modal-body">
			    <form method="POST" class="change_school_info" action="{{URL::to('/')}}/edit_school_info">
			    	@csrf
			    	<input type="hidden" name="edit_for" class="edit_for_field">
				   <div class="row form-group">
						<div class="col-md-12">
							<label class="edit_for"></label>
							<input type="text" name="field_change" class="form-control prefile_text_input only_letters" maxlength="50" minlength="3" placeholder="" required/>
						</div>
					</div>
					<div class="row text-center">
						<div class="col-md-12 btn_submit">
							<label class="password_change_success success"></label>
							<button type="submit" class="btn btn-link btn-submit">Submit <i class="fa fa-spinner fa-spin spinner_show hide" aria-hidden="true"></i></button>
						</div>
					</div>
				</form>
        </div>
      </div>
    </div>
  </div>



  <!-- Modal -->
<!--   <div class="modal fade" id="changeProfilePic" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content report_inner">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="{{URL::to('/')}}/public/images/close.png"></button>
          <h4 class="modal-title school_edit_title">Change Profile Picture</h4>
        </div>
        <div class="modal-body">
			    <form method="POST" class="change_school_info" action="{{URL::to('/')}}/edit_school_info">
			    	@csrf
			    	<input type="hidden" name="edit_for" class="edit_for_field">
				   <div class="row form-group upload_grade">
						<div class="col-md-12">
							<label class="edit_for"></label>
							<button type="button" class="file-upload-button" tabindex="-1"><i class="fa fa-upload" aria-hidden="true"></i>  Upload File</button>
						</div>
					</div>
					<div class="row text-center">
						<div class="col-md-12 btn_submit">
							<label class="password_change_success success"></label>
							<button type="submit" class="btn btn-link btn-submit">Submit <i class="fa fa-spinner fa-spin spinner_show hide" aria-hidden="true"></i></button>
						</div>
					</div>
				</form>
        </div>
      </div>
    </div>
  </div> -->
<div class="modal fade" id="changeProfilePic" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content report_inner">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="{{URL::to('/')}}/public/images/close.png"></button>
          <h4 class="modal-title">Upload Profile Picture</h4>
		</div>
        <form method="POST" class="validate_change_profile" action="{{URL::to('/')}}/update_profile_image" enctype="multipart/form-data" novalidate="novalidate">
        	@csrf
        	        <div class="modal-body">
					<div class="row form-group">
							<div class="col-md-12">
								<label>Picture</label>
								
								<div class="custom-file-upload1">
									<!--<label for="file">File: </label>--> 
									<div class="file-upload-wrapper">
										<input type="file" id="file1" name="profile_pic" accept="image/*"  class="choose_image_file" required>
										
									</div>
								</div>
							</div>
						</div>
						
						<div class="row text-center">
							<div class="col-md-12 btn_submit">
								<button class="btn btn-link">Submit</button>
							</div>
						</div>
		        </div>
    	</form>
      </div>
    </div>
  </div>

@include("Elements.school_footer")

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
<script src="{{URL::to('/')}}/public/js/custom.js"></script>
<script>
//Reference: 
//https://www.onextrapixel.com/2012/12/10/how-to-create-a-custom-file-input-with-jquery-css3-and-php/
;(function($) {

		  // Browser supports HTML5 multiple file?
		  var multipleSupport = typeof $('<input />')[0].multiple !== 'undefined',
		      isIE = /msie/i.test( navigator.userAgent );

		  $.fn.customFile = function() {

		    return this.each(function() {

		      var $file = $(this).addClass('custom-file-upload-hidden'), // the original file input
		          $wrap = $('<div class="file-upload-wrapper">'),
		          $input = $('<input type="text" class="file-upload-input" placeholder="Upload Grade Roster" readonly required/>'),
		          // Button that will be used in non-IE browsers
		          $button = $('<button type="button" class="file-upload-button"><i class="fa fa-upload" aria-hidden="true"></i><span class="file_upload_text">Upload File</span></button>'),
		          // Hack for IE
		          $label = $('<label class="file-upload-button" for="'+ $file[0].id +'">Select a File</label>');

		      // Hide by shifting to the left so we
		      // can still trigger events
		      $file.css({
		        position: 'absolute',
		        left: '-9999px'
		      });

		      $wrap.insertAfter( $file )
		        .append( $file, $input, ( isIE ? $label : $button ) );

		      // Prevent focus
		      $file.attr('tabIndex', -1);
		      $button.attr('tabIndex', -1);

		      $button.click(function () {
		        $file.focus().click(); // Open dialog
		      });

		      $file.change(function() {

		        var files = [], fileArr, filename;

		        // If multiple is supported then extract
		        // all filenames from the file array
		        if ( multipleSupport ) {
		          fileArr = $file[0].files;
		          for ( var i = 0, len = fileArr.length; i < len; i++ ) {
		            files.push( fileArr[i].name );
		          }
		          filename = files.join(', ');

		        // If not supported then just take the value
		        // and remove the path to just show the filename
		        } else {
		          filename = $file.val().split('\\').pop();
		        }

		        $input.val( filename ) // Set the value
		          .attr('title', filename) // Show filename in title tootlip
		          .focus(); // Regain focus

		      });

		      $input.on({
		        blur: function() { $file.trigger('blur'); },
		        keydown: function( e ) {
		          if ( e.which === 13 ) { // Enter
		            if ( !isIE ) { $file.trigger('click'); }
		          } else if ( e.which === 8 || e.which === 46 ) { // Backspace & Del
		            // On some browsers the value is read-only
		            // with this trick we remove the old input and add
		            // a clean clone with all the original events attached
		            $file.replaceWith( $file = $file.clone( true ) );
		            $file.trigger('change');
		            $input.val('');
		          } else if ( e.which === 9 ){ // TAB
		            return;
		          } else { // All other keys
		            return false;
		          }
		        }
		      });

		    });

		  };

		  // Old browser fallback
		  if ( !multipleSupport ) {
		    $( document ).on('change', 'input.customfile', function() {

		      var $this = $(this),
		          // Create a unique ID so we
		          // can attach the label to the input
		          uniqId = 'customfile_'+ (new Date()).getTime(),
		          $wrap = $this.parent(),

		          // Filter empty input
		          $inputs = $wrap.siblings().find('.file-upload-input')
		            .filter(function(){ return !this.value }),

		          $file = $('<input type="file" id="'+ uniqId +'" name="'+ $this.attr('name') +'"/>');

		      // 1ms timeout so it runs after all other events
		      // that modify the value have triggered
		      setTimeout(function() {
		        // Add a new input
		        if ( $this.val() ) {
		          // Check for empty fields to prevent
		          // creating new inputs when changing files
		          if ( !$inputs.length ) {
		            $wrap.after( $file );
		            $file.customFile();
		          }
		        // Remove and reorganize inputs
		        } else {
		          $inputs.parent().remove();
		          // Move the input so it's always last on the list
		          $wrap.appendTo( $wrap.parent() );
		          $wrap.find('input').focus();
		        }
		      }, 1);

		    });
		  }

}(jQuery));

$('input[type=file]').customFile();


$("#changeProfilePic").find(".file-upload-input").attr("placeholder","Select profile image");

$(".custom-file-upload1").find(".file_upload_text").text("Choose Image");
</script>

</body>

</html>


