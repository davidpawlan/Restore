<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
/*Before Login school/Admin--*/
Route::get("login","UserController@loginFrom")->name("login-form");
Route::post("login","UserController@login")->name("login");
Route::get("/logout","UserController@logout")->name("logout");

Route::get("admin","AdminController@loginFrom");
Route::get("admin/login","AdminController@loginFrom");
Route::post("admin/login","AdminController@login")->name("admin.login");

/*Forgot password*/
Route::get("forgot-pasword","UserController@forgotPassword")->name("forgot-pasword");
Route::post("forgot-password","UserController@requestPassword")->name("request-pasword");
Route::get("reset-password/{token}","UserController@resetPasswordForm")->name("reset-password-show");
Route::post("reset-password","UserController@resetPassword")->name("reset-password");
/*After Login School--*/
Route::group(['middleware' => 'school'],function(){
	Route::get('/', "SchoolController@index")->name("school.index");
	Route::get('grade/{gradeId}/students',"SchoolController@getGradeStudents")->name('grade.students');
	Route::get('/students/{gradeId}/gender',"SchoolController@getStudentGender")->name("students.gender");
	/*Reports--*/
	Route::get("/reports","SchoolController@showReportForm")->name("reports.create");
	Route::post("/reports","SchoolController@storeReports")->name("reports.store");
	/*Reports--*/
	Route::get("/analytics","SchoolController@showAnalytics")->name("analytics.index");
	/*Settings--*/
	Route::get("/settings","SchoolController@settings")->name("settings.index");
	Route::post("/upload-grade-roaster","SchoolController@uploadGradeRoaster");
	Route::get("delete-roster/{id}", "SchoolController@deleteRoster");
	/*Settings--*/


	/*Report History*/
	Route::get("report-history","SchoolController@reportHistory");

	
});
Route::post("/update_profile_image","SchoolController@changeProfileImage");
Route::post("/edit_school_info","SchoolController@editSchoolInfo");
/*After Login Admin Routes--*/
Route::group(['middleware' => 'admin','prefix' => "admin"],function(){
	Route::get("/analytics",'AdminController@showAnalytics')->name("analytics_admin.index");
	Route::get("/schools","AdminController@schools")->name("schools.index");
	Route::post("/schools","AdminController@schoolStore")->name("school.store");
	Route::post("/schools/update","AdminController@schoolUpdate")->name("school.update");
	Route::get("/schools/{id}/delete", "AdminController@deleteSchool")->name("school.delete");
	Route::get("/schools/{id}/deactivate","AdminController@deactivateSchool")->name("school.deactivate");
	Route::get("/schools/{id}/activate","AdminController@activateSchool")->name("school.activate");
	Route::get("/settings","AdminController@settings")->name("admin.settings.index");
	Route::get("/logout","AdminController@logout");

	/*Report History*/
	Route::get("report-history","AdminController@reportHistory");
});

Route::post("/change-password","UserController@changePassword");
Route::get("/schools/{schoolId}/grades/{gradeId}/students","AdminController@getStudentsOfSchoolGrade");
Route::get("reports/{reportId}","AdminController@reportDetails");