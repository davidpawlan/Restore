<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\School;
use App\Report;
use App\Grade;
use App\Student;
use Hash;
use Auth;
use Mail;
use Redirect;
use Config;
use Session;
class AdminController extends Controller
{
    private $Report;
    public function __construct(){
        $this->Report = new Report;
    }

    /*****Show Login Form For Admin*****/
    public function loginFrom(){
    	return view("Admin.login");
    }

    /*****Authenticate If Login As Admin*****/
    public function login(Request $request){
    	$validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        /****Login for admin with guard admin*****/
        if(Auth::guard('admin')->attempt(['email' => $request['email'], 'password' => $request['password'], 'type' => "A" ])){
            return Redirect::to('admin/analytics');
        }else{
            return Redirect::back()->with("error","You have entered invaild credentails, please try again");
        }
    }
    /*****Admin Analytics*****/
    public function showAnalytics(Request $request){
        /*****If Filter Data Is Sent From URL******/
        $schoolId = ""; $gradeId = "";$studentId="";$filterBy="";
        if(isset($request['school']) && !empty($request['school'])){
            $schoolId = trim($request['school']);
        }
        if(isset($request['grade']) && !empty(trim($request['grade']))){
            $gradeId = trim($request['grade']);
        }
        if(isset($request['student']) && !empty(trim($request['student']))){
            $studentId = trim($request['student']);
        }
        /**Get The Duration**/
        if(isset($_GET['duration']) && !empty(trim($_GET['duration']))){
            $duration = $_GET['duration'];
            if($duration == "D"){
                /*Daily(7am to 4Pm)*/
                $timeDuration = "D";
                $startDate  = date("Y-m-d");
                $endDate    = date("Y-m-d");
                /*Daily Time Chart Data*/
                $timeChartForSchool = $this->Report->getTimeChartForSchoolDaily($schoolId,$gradeId,$studentId,$filterBy);

            }else if($duration == "W"){
                /*--Weekly(Mon-Sat)--*/
                $timeDuration = "W";
                $startDate = date('Y-m-d',strtotime('monday this week'));/*Start date of the week__*/
                $endDate = date('Y-m-d',strtotime('saturday this week'));/*End date of the week__*/
                
                $timeChartForSchool = $this->Report->getTimeChartForSchoolWeekly($schoolId,$gradeId,$studentId,$filterBy,$startDate,$endDate);
            }else if($duration == "M"){
                /**Monthly(01-30/31)**/
                 $timeDuration = "M";
                 $startDate = date('Y-m-')."01";/*Start date of the Month 1st date*/
                 $getTotalNumberOfDaysInMonth = date('t',strtotime($startDate));
                 $endDate = date('Y-m-')."$getTotalNumberOfDaysInMonth";/*End date of the Month lase date*/
                 $timeChartForSchool = $this->Report->getTimeChartForSchoolMonthly($schoolId,$gradeId,$studentId,$filterBy,$startDate,$endDate);
            }else if($duration == "Y"){
                /**Yearly(Jan-Dec)**/
                $timeDuration = "Y";
                $getCurrentMonth = date("n");
                if($getCurrentMonth < 8){
                   $startDate = date("Y",strtotime("-1 year"))."-08-01";/*Start from August to June month of the Year*/
                   $endDate   = date("Y-06-d");/*End date(June) of year--*/
                }else{
                    $startDate = date('Y')."-08-01";/*Start August to June*/
                    $endDate   = date("Y-m-d");/*End date of year--*/
                }
                $timeChartForSchool = $this->Report->getTimeChartForSchoolYearly($schoolId,$gradeId,$studentId,$filterBy,$startDate,$endDate);
            }else if($duration == "C"){
                 /**Custom(Start date-End date(Restirect for 30 Days))**/
                $timeDuration  = "C";
                $start_Date    = $request->from_date;
                $startDate     = date("Y-m-d",strtotime($start_Date));
                $end_Date      = $request->to_date;
                $endDate       = date("Y-m-d",strtotime($end_Date));
                $timeChartForSchool = $this->Report->getTimeChartForSchoolMonthly($schoolId,$gradeId,$studentId,$filterBy,$startDate,$endDate);
           }else{
                /**Default Daily**/
                $timeDuration = "D";
                $startDate  = date("Y-m-d");
                $endDate    = date("Y-m-d");
                /*Time Chart*/
                $timeChartForSchool = $this->Report->getTimeChartForSchoolDaily($schoolId,$gradeId,$studentId,$filterBy);
            }
        }else{
            /**Default Daily**/
            $timeDuration = "D";
            $startDate  = date("Y-m-d");
            $endDate    = date("Y-m-d");
            /*Time Chart*/
            $timeChartForSchool = $this->Report->getTimeChartForSchoolDaily($schoolId,$gradeId,$studentId,$filterBy);
        }
        /**********************All Charts Data Start************************/

        /*********************Time Reports Start--****************/
        /*Show 7Am to 4Pm reports In daily--*/
        $timeChrtArr = array();
        if($timeDuration == "D"){
            for ($i=7;$i<=16;$i++){
                $timeChrtArr[$i]['reports'] = 0;
                $timeChrtArr[$i]['time'] = strtoupper(date('h a',strtotime($i.":00")));
            }
            if(!empty($timeChartForSchool)){
                foreach($timeChartForSchool as $time){
                    $timeFor = $time->HOUR; $totalReports = $time->total_reports;
                    $timeChrtArr[$timeFor]['reports'] = $totalReports;
                }
            }
        }
        /* Show from monday to Saturday*/
        if($timeDuration == "W"){
            $start_date = $startDate;
            $end_date   = $endDate;
            while (strtotime($start_date) <= strtotime(date("Y-m-d"))) {
                $i = strtotime($start_date);
                $timeChrtArr[$i]['reports'] = 0;
                $timeChrtArr[$i]['time']    = date("D",strtotime($start_date));
                $start_date                 = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
             }
             if(!empty($timeChartForSchool)){
                foreach($timeChartForSchool as $time){
                    $timeFor = strtotime($time->report_date); $totalReports = $time->total_reports;
                    if(isset($timeChrtArr[$timeFor]['reports'])){
                        $timeChrtArr[$timeFor]['reports'] = $totalReports;
                    }
                }
             }
        }
         /* Show monthly 1st to 30/31 th*/
        if($timeDuration == "M"){
            $start_date = $startDate;
            $end_date   = $endDate;
            
            while (strtotime($start_date) <= strtotime(date("Y-m-d"))) {
                $i = strtotime($start_date);
                $timeChrtArr[$i]['reports'] = 0;
                $timeChrtArr[$i]['time']    = date("dS",strtotime($start_date));
                $start_date                 = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
             }
            if(!empty($timeChartForSchool)){
                foreach($timeChartForSchool as $time){
                    $timeFor = strtotime($time->report_date); $totalReports = $time->total_reports;
                    if(isset($timeChrtArr[$timeFor]['reports'])){
                        $timeChrtArr[$timeFor]['reports'] = $totalReports;
                    }
                }
             }
        }
        /* Show Yearly Jan to Dec*/
        if($timeDuration == "Y"){
            $start_date = $startDate;
            $end_date   = $endDate;
            $getCurrentMonth = date("n");
            if($getCurrentMonth == 7){
                $toDate = date("Y-06-30");
            }else{
                $toDate = date("Y-m-d");
            }
            while (strtotime($start_date) <= strtotime($toDate)) {
                $i = date("M",strtotime($start_date));
                $timeChrtArr[$i]['reports'] = 0;
                $timeChrtArr[$i]['time']    = date("M",strtotime($start_date))." ".date("Y",strtotime($start_date));
                $start_date                 = date ("Y-m-d", strtotime("+1 month", strtotime($start_date)));
             }
             if(!empty($timeChartForSchool)){
                foreach($timeChartForSchool as $time){
                    $reportMonth = date("Y-").$time->report_month."-01";
                    $timeFor = date("M",strtotime($reportMonth)); $totalReports = $time->total_reports;
                    if(isset($timeChrtArr[$timeFor]['reports'])){
                        $timeChrtArr[$timeFor]['reports'] = $totalReports;
                    }
                }
             }
        }
         /* Show monthly 1st to 30/31 th*/
        if($timeDuration == "C"){
            $start_date = $startDate;
            $end_date   = $endDate;
            while (strtotime($start_date) <= strtotime($end_date)) {
                $i = strtotime($start_date);
                $timeChrtArr[$i]['reports'] = 0;
                $timeChrtArr[$i]['time']    = date("dS",strtotime($start_date));
                $start_date                 = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
             }
            if(!empty($timeChartForSchool)){
                foreach($timeChartForSchool as $time){
                    $timeFor = strtotime($time->report_date); $totalReports = $time->total_reports;
                    if(isset($timeChrtArr[$timeFor]['reports'])){
                        $timeChrtArr[$timeFor]['reports'] = $totalReports;
                    }
                }
            }
        }
        $timeChartForSchool = $timeChrtArr;
        /*********************Time Reports Ends--****************/
            /*Student list of a grade--*/
            $getStudentsOfGrade = array();
            if(isset($_GET['school']) && !empty(trim($_GET['school'])) && isset($_GET['grade']) && !empty(trim($_GET['grade']))){
                $schoolId = trim($_GET['school']);
                $gradeId  = trim($_GET['grade']);
                $getStudentsOfGrade = Student::where("user_id",$schoolId)->where("grade_id",$gradeId)->where('status','1')->get();
            }
 
        /*************** Restorative Practice Chart Data*****************/
        /* data is filtered with duration(start date and end date-- and optional school/student/grade*/
            $RestorativePractice['self_awareness']      =  $this->Report->restorativePractice('self_awareness',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $RestorativePractice['self_management']     =  $this->Report->restorativePractice('self_management',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $RestorativePractice['responsible_decision_making'] =  $this->Report->restorativePractice('responsible_decision_making',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $RestorativePractice['relationship_skills'] =  $this->Report->restorativePractice('relationship_skills',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $RestorativePractice['social_awareness']    =  $this->Report->restorativePractice('social_awareness',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);

        /**************Gender Chart Data for Male and femail for each Practice*********/
            $gender['self_awareness']['Male']       = $this->Report->gender('self_awareness','M',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $gender['self_awareness']['Female']     = $this->Report->gender('self_awareness','F',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $gender['self_management']['Male']      = $this->Report->gender('self_management','M',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $gender['self_management']['Female']    = $this->Report->gender('self_management','F',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $gender['responsible_decision_making']['Male']    = $this->Report->gender('responsible_decision_making','M',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $gender['responsible_decision_making']['Female']    = $this->Report->gender('responsible_decision_making','F',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $gender['relationship_skills']['Male']    = $this->Report->gender('relationship_skills','M',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $gender['relationship_skills']['Female']  = $this->Report->gender('relationship_skills','F',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $gender['social_awareness']['Male']       = $this->Report->gender('social_awareness','M',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $gender['social_awareness']['Female']       = $this->Report->gender('social_awareness','F',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);

        /******************Behavior Chart Data******************/
            $Behavior = $this->Report->getBehaviour($schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            if(!$Behavior->isEmpty()){
                $Behavior = $Behavior->toArray();  
            }else{
                $Behavior = array();
            }
            
        /********************Location Chart Data****************/
            $locations = $this->Report->getLocations($schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            if(!$locations->isEmpty()){
                $locations = $locations->toArray();  
            }else{
                $locations = array();
            }

        /****************** Interventions Chart Data*************/
            $Interventions  = $this->Report->getInterventions($schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            if(!$Interventions->isEmpty()){
                $Interventions = $Interventions->toArray();  
            }else{
                $Interventions = array();
            }

        /***************************Charts Data ends************************/
            /*All active school list--*/
            $schools = User::where("type","S")->where("status","1")->select("id","name")->orderBy("id","DESC")->get();
            $grades   = Grade::all();
            
           
        /***********Data to generate PDF*************************/
            if(isset($_GET['school']) && !empty(trim($_GET['school']))){
                $schoolName = User::where("id",$_GET['school'])->pluck("name");
                $pdfArray['school'] = $schoolName[0];
                $pdfArray['total_schools'] = "1";
            }else{
                $pdfArray['school'] = "All Schools";
                $pdfArray['total_schools'] = User::where("type","S")->where("status","1")->count(); 
            }

            if(isset($_GET['grade']) && !empty(trim($_GET['grade']))){
                $gradeName = Grade::where("id",$_GET['grade'])->pluck("name");
                $pdfArray['grade'] = $gradeName[0];
                $pdfArray['total_grade'] = "1";
            }else{
                $pdfArray['grade'] = "All Grades";
                $pdfArray['total_grade'] = Grade::count(); 
            }

            if(isset($_GET['student']) && !empty(trim($_GET['student']))){
                $studentGet = Student::where("id",$_GET['student'])->select("name","roll_number")->first();
                $studentName = $studentGet['name'];
                if(!empty($studentGet['roll_number'])){
                  $studentName .= "(#".$studentGet['roll_number'].")";
                }
                $pdfArray['student'] = $studentName;
                $pdfArray['total_student'] = "1";
            }else{
                $pdfArray['student'] = "All Students";
                $totalStudents  = Student::where("status","1");
                if(isset($_GET['school']) && !empty($_GET['school'])){
                    $totalStudents->where("user_id",$_GET['school']);
                }
                if(isset($_GET['grade']) && !empty($_GET['grade'])){
                    $totalStudents->where("grade_id",$_GET['grade']);
                }
                $totalStudents = $totalStudents->count();
                $pdfArray['total_student'] = $totalStudents;
            }
            if($timeDuration == "D"){
                $pdfArray['time_period'] = "Daily";
            }elseif($timeDuration == "W"){
                 $pdfArray['time_period'] = "Weekly";
            }elseif($timeDuration == "M"){
                 $pdfArray['time_period'] = "Monthly";
            }elseif($timeDuration == "Y"){
                 $pdfArray['time_period'] = "Yearly";
            }elseif($timeDuration == "C"){
                 $pdfArray['time_period'] = "Custom";
            }else{
                $pdfArray['time_period'] = "Daily";
            }
            $pdfArray['start_date'] = isset($startDate ) ? $startDate  : date("Y-m-d");
            $pdfArray['end_date'] = isset($endDate ) ? $endDate  : date("Y-m-d");
            /**********Total numbers of reports for selected duration********/
            $countTotalNumbersOfReports = $this->Report->countTotalNumbersOfReports($schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
            $pdfArray['total_reports'] = $countTotalNumbersOfReports;
        /*******Data for PDF ends***************************/
            return view("Admin.analytics",['RestorativePractice' => $RestorativePractice, 'gender' => $gender, 'Behavior' => $Behavior, 'locations' => $locations, 'Interventions' => $Interventions, 'schools' => $schools, 'grades'=> $grades, 'students' => $getStudentsOfGrade,'timeChart' => $timeChartForSchool,'pdfArray' => $pdfArray]); 
    }

    /****Get all Schools List****/
    public function schools(){
        $totalSchools = User::where("type","S")->count();
        $paginationLimit = Config::get("constants.TABLE_LIMIT");
        $allSchools = User::with('school')->where(['type' => 'S'])->orderBy("id","DESC")->paginate($paginationLimit);
    	return view("Admin.schools",compact('allSchools','totalSchools'));
    }

    /****Insert school*****/
    public function schoolStore(Request $request){
        $email = $request['school_email'];
        $checkEmailExist = User::where(['email' => $email])->first();
        if($checkEmailExist){
            return $this->responseInJSON("-1","Email already exist");
            die;
        }
        /*create School array for users table*/
        $createSchoolUser = [
                                'name'           => $request['school_name'],
                                'email'          => $request['school_email'],
                                'password'       => Hash::make($request['school_password']),
                                'type'           => "S",
                                'status'         => "1",
                                'created_at'     => date("Y-m-d H:i:s")
                            ];
        $user  = User::insertGetId($createSchoolUser);
        if($user){
             /*Insert data in school with user id*/
            School::insert([
                    "user_id"        => $user,
                    "principle_name" => $request['principle_name'],
                    "plain_password" => $request['school_password'],
                    "profile_image"  => ""
            ]);

            /***Send email of account creation to the school principle Email Id***/
            $data = ["data" => $request->all()];
            Mail::send('Emails.school-create', $data, function ($message) use ($email) {
                $msg = "Account Created Successfully";
                $message->to($email)->subject('Restore: '.$msg);
            });
            return $this->responseInJSON("1","School registered successfully");
            die;
        }
        return $this->responseInJSON("0","Something wrong, try again");
        die;
    }
    
    /*****Delete School By Admin******/
    public function deleteSchool($id){
        School::where("user_id",$id)->delete();
        User::where("id",$id)->delete();
        Report::where("user_id",$id)->delete();
        Student::where("user_id",$id)->delete();
        return Redirect::back()->with("success","School deleted successfully");
    }

    /*****Deactivate School By Admin*****/
    public function deactivateSchool($id){
        User::where("id",$id)->update(['status' => "0"]);
        Student::where("user_id",$id)->update(['status' => "0"]);
        Session::flash('success', 'School deactivated successfully'); 
        return Redirect::back();
    }

    /*****Activate school by admin*****/
    public function activateSchool($id){
        User::where("id",$id)->update(['status' => "1"]);
        Student::where("user_id",$id)->update(['status' => "1"]);
        Session::flash('success', 'School activated successfully'); 
        return Redirect::back();
    }

    /*****Update School By Admin*****/
    public function schoolUpdate(Request $request){
       $schoolId    = $request['school_id'];
       $schoolEmail = $request['school_email'];
       $checkEmailExist = User::where("email",$schoolEmail)->where("id","!=",$schoolId)->select("id")->first();
       if(!empty($checkEmailExist)){
            return $this->responseInJSON("-1","Email already exist");
            die;
       }else{
          /*Update School In Users--*/
          $updateSchoolUser = [
                                'name'           => $request['school_name'],
                                'email'          => $request['school_email'],
                               'updated_at'     => date("Y-m-d H:i:s")
                             ];
         if(isset($request['school_password']) && !empty($request['school_password'])){
            $updateSchoolUser['password'] = Hash::make($request['school_password']);
         }
         $userUpdate = User::where("id",$schoolId)->update($updateSchoolUser);
         /*Update School In Schools--*/
         $schoolArray =  [
                            "principle_name" => $request['principle_name']
                        ];
            if(isset($request['school_password']) && !empty($request['school_password'])){
                    $schoolArray["plain_password"] = $request['school_password'];
            /*****Send mail to Principle if password changed by admin for the school*****/
                    $data = ["data" => $request->all()];
                    Mail::send('Emails.school-password-changed', $data, function ($message) use ($schoolEmail) {
                        $msg = "Account Password Changed";
                        $message->to($schoolEmail)->subject('Restore: '.$msg);
                    });
            }
            School::where("user_id",$schoolId)->update($schoolArray);
            return $this->responseInJSON("1","School updated successfully");
            die;
       }
    }

   /*****Get Students Of A School For A Grade*****/
    public function getStudentsOfSchoolGrade($school,$grade){
       $getStudents = Student::where("user_id",$school)->where("grade_id",$grade)->where('status','1')->get();
       $students    = "<option value=''>All Students</option>";
       if(isset($getStudents) && !empty($getStudents)){
            foreach($getStudents as $studnts){
               $students .= "<option value='".$studnts->id."'>".$studnts->name."</option>";
            }
       }
       echo $students;
    }

   /*****show Settings*****/
    public function settings(){
       $userId            = Auth::guard("admin")->id();
       $getDetails        = User::where("id",$userId)->first()->toArray();
       $getAllGrades = array();
       $getMyGradeRosters = array();
       return view("Admin.settings",['details' => $getDetails,'grades' => $getAllGrades,'grade_rosters' => $getMyGradeRosters]);
    }

    /*****Report History*****/
    public function reportHistory(Request $request){
    /*****If data filtered Start*****/
        $schoolId = ""; $gradeId = "";$studentId="";$filterBy="";$pagination="FALSE";
        if(isset($request['school']) && !empty($request['school'])){
            $schoolId = trim($request['school']);
            $pagination = "TRUE";
        }
        if(isset($request['grade']) && !empty(trim($request['grade']))){
            $gradeId = trim($request['grade']);
            $pagination = "TRUE";
        }
        if(isset($request['student']) && !empty(trim($request['student']))){
            $studentId = trim($request['student']);
            $pagination = "TRUE";
        }
    /*****If data filtered End*****/
        /**All Schools**/
        $schools = User::where("type","S")->where("status","1")->select("id","name")->orderBy("id","DESC")->get();
        $grades   = Grade::all();
        $getStudentsOfGrade = array();
        if(isset($_GET['school']) && !empty(trim($_GET['school'])) && isset($_GET['grade']) && !empty(trim($_GET['grade']))){
            $schoolId = trim($_GET['school']);
            $gradeId  = trim($_GET['grade']);
            $getStudentsOfGrade = Student::where("user_id",$schoolId)->where("grade_id",$gradeId)->where('status','1')->get();
        }
        $students = $getStudentsOfGrade;

        if($pagination == "FALSE"){
            $getGradeHistory = $this->Report->getLastFewReports();/*Fewer Reports*/
        }else{
            $getGradeHistory = $this->Report->reportHistory($schoolId,$gradeId,$studentId);
        }

     
     return view("Admin.report-history",compact('schools','grades','getGradeHistory','students','pagination'));
    }

    /*****Report Details*****/
    public function reportDetails($reportId){
        $getReportDetails = $this->Report->reportDetails($reportId);
        if(!empty($getReportDetails)){
            echo view("Render.report_details",['report' => $getReportDetails]);
        }else{
            echo 0;
        }
    }
   
    /*****Logout admin*****/
    public function logout(){
        /****Logout Admin from admin Guard*****/
        Auth::guard("admin")->logout();
        return Redirect::to("/admin/login");   
    }
}