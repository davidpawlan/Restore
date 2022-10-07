<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Grade;
use App\School;
use App\GradeRoster;
use App\Student;
use App\Behaviour;
use App\Location;
use App\Intervention;
use App\Report;
use Redirect;
use Auth;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    private $School;private $Report;
    public function __construct(){
        $this->School = new School;
        $this->Report = new Report;
    }
/*****Homepage for School*****/
  public function index(Request $request){
    $userId   = Auth::id(); 
    $schoolId = $userId;
    $getSchoolStudents =array();
    $getGradeName = "";

    $gradeId = "";$studentId="";
    if(isset($_GET['grade']) && !empty($_GET['grade'])){
      $getGradeName = Grade::where("id",$gradeId)->select('name')->first();
      $gradeId = $_GET['grade'];
    }
    if(isset($_GET['student']) && !empty($_GET['student'])){
      $studentId = base64_decode($_GET['student']);
    }
    /*get all students/Grade students*/
    $getSchoolStudents = $this->School->getSchoolStudents($userId,$gradeId);

    $filterBy = "D";
    if(isset($_GET['filter']) && !empty($_GET['filter'])){
      $filterBy = $_GET['filter'];
    }
    $duration = $filterBy;
    if($duration == "D"){
        /**Daily(7am to 4Pm)**/
        $timeDuration = "D";
        $startDate  = date("Y-m-d");
        $endDate    = date("Y-m-d");
        /*Daily Time Chart*/
        $timeChartForSchool = $this->Report->getTimeChartForSchoolDaily($schoolId,$gradeId,$studentId,$filterBy);
    }else if($duration == "W"){
          /**Weekly(Mon-Sat)**/
          $timeDuration = "W";
          $startDate = date('Y-m-d',strtotime('monday this week'));/*Start date of the week__*/
          $endDate = date('Y-m-d',strtotime('saturday this week'));/*End date of the week__*/
          $timeChartForSchool = $this->Report->getTimeChartForSchoolWeekly($schoolId,$gradeId,$studentId,$filterBy,$startDate,$endDate);
    }

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
        $timeChartForSchool = $timeChrtArr;
      
        /*Restorative Practice Data*/
        $RestorativePractice['self_awareness']      =  $this->Report->restorativePractice('self_awareness',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
        $RestorativePractice['self_management']     =  $this->Report->restorativePractice('self_management',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
        $RestorativePractice['responsible_decision_making'] =  $this->Report->restorativePractice('responsible_decision_making',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
        $RestorativePractice['relationship_skills'] =  $this->Report->restorativePractice('relationship_skills',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
        $RestorativePractice['social_awareness']    =  $this->Report->restorativePractice('social_awareness',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
    
        $getAllGrades = Grade::all();
        return view("School.index",['gradeName' => $getGradeName,'grades' => $getAllGrades,'students' => $getSchoolStudents,'RestorativePractice' => $RestorativePractice, 'timeChart' => $timeChartForSchool]);
  }

	/*****Show Report Form*****/
   public function showReportForm(Request $request){
      $userId            = Auth::id();
      $getGradesList     = Grade::all();
      $getBehavioursList = Behaviour::all();
      $getLocationList   = Location::all();

      $getInterventionList = Intervention::all();
      if(isset($_GET['grade']) && !empty(trim($_GET['grade']))){
        $gradeId = $_GET['grade'];
        $getStudentsOfGrade = $this->School->getSchoolStudents($userId,$gradeId);
      }else{
        $getStudentsOfGrade = array();
      }
      return view("School.reports_form",['grades' => $getGradesList,'behaviours' => $getBehavioursList,'locations' => $getLocationList, 'interventions' => $getInterventionList,'students' => $getStudentsOfGrade]);
   }

   /*****Insert Report TO Database*****/
   public function storeReports(Request $request){
     $userId = Auth::id();
     $date = $request['date'];
     $reportDate = date("Y-m-d",strtotime($date));
     
     $time = strtoupper($request['time']);
     $reportTime =  date("H:i",strtotime($time));

     $studenNameDetails = Student::where("id",$request['student_id'])->select("name","last_name")->first();
     $studentName = trim($studenNameDetails->name . " " . $studenNameDetails->last_name);

     $report = new Report();
     $report->grade_id    = $request['grade_id'];
     $report->user_id     = $userId;
     $report->student_id  = $request['student_id'];
     $report->gender      = $request['gender'];
     $report->behaviour_id      = $request['behaviour_id'];
     $report->location_id       = $request['location_id'];
     $report->intervention_id   = $request['intervention_id'];
     $report->date     = $reportDate;
     $report->time     = $reportTime;
     $report->self_awareness     = $request['self_awareness'];
     $report->self_management    = $request['self_management'];
     $report->responsible_decision_making     = $request['responsible_dec_make'];
     $report->relationship_skills  = $request['relationship_skills'];
     $report->social_awareness     = $request['social_awareness'];
     $report->other_notes          = $request['notes'];
     $report->student             = $studentName;
     $report->status               = '1';
     $report->created_at           = date("Y-m-d H:i:s");
     $report->save();
      return Redirect::back()->with("success","Report added successfully");
   }

   /*****Show Analytics*****/
   public function showAnalytics(Request $request){
      $getAllGrades = Grade::all();
      $schoolId = Auth::id(); 
      $gradeId = "";
      $studentId="";
      $filterBy="";
      if(isset($request['grade']) && !empty(trim($request['grade']))){
          $gradeId = trim($request['grade']);
      }
      if(isset($request['student']) && !empty(trim($request['student']))){
          $studentId = trim($request['student']);
      }
        if(isset($_GET['duration']) && !empty(trim($_GET['duration']))){
            $duration = $_GET['duration'];
            if($duration == "D"){
                /**Daily(7am to 4Pm)**/
                $timeDuration = "D";
                $startDate  = date("Y-m-d");
                $endDate    = date("Y-m-d");
                /**Daily Time Chart**/
                $timeChartForSchool = $this->Report->getTimeChartForSchoolDaily($schoolId,$gradeId,$studentId,$filterBy);

            }else if($duration == "W"){
                /**Weekly(Mon-Sat)**/
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
                /*If current month is less than Aug then start date should be previous year--*/
                if($getCurrentMonth < 8){
                   $startDate = date("Y",strtotime("-1 year"))."-08-01";/*Start from August to June month of the Year*/
                   $endDate   = date("Y-06-d");/*End date of year--*/
                }else{
                    $startDate = date('Y')."-08-01";/*Start August to June*/
                    $endDate   = date("Y-m-d");/*End date of year--*/
                }
                $timeChartForSchool = $this->Report->getTimeChartForSchoolYearly($schoolId,$gradeId,$studentId,$filterBy,$startDate,$endDate);
            }else if($duration == "C"){
                 /**Custom(Start date-End date(Restirect to a month))**/
                $timeDuration  = "C";
                $start_Date    = $request->from_date;
                $startDate     = date("Y-m-d",strtotime($start_Date));
                $end_Date      = $request->to_date;
                $endDate       = date("Y-m-d",strtotime($end_Date));
                $timeChartForSchool = $this->Report->getTimeChartForSchoolMonthly($schoolId,$gradeId,$studentId,$filterBy,$startDate,$endDate);
           }else{
                /**Default daily**/
              $timeDuration = "D";
              $startDate  = date("Y-m-d");
              $endDate    = date("Y-m-d");
              /**Time Chart**/
              $timeChartForSchool = $this->Report->getTimeChartForSchoolDaily($schoolId,$gradeId,$studentId,$filterBy);
            }
        }else{
            /**Default daily**/
            $timeDuration = "D";
            $startDate  = date("Y-m-d");
            $endDate    = date("Y-m-d");
            /*Time Chart*/
            $timeChartForSchool = $this->Report->getTimeChartForSchoolDaily($schoolId,$gradeId,$studentId,$filterBy);
        }

/**********************All Charts Data Start************************/
        /*********************Time Reports Start--****************/
        /*Show 7Am to 4Pm reports In daily--*/
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
        if((isset($_GET['school']) && !empty(trim($_GET['school'])) && isset($_GET['grade']) && !empty(trim($_GET['grade']))) || (isset($_GET['grade'])) && !empty($_GET['grade'])){
            if(isset($_GET['school'])){
              $schoolId = trim($_GET['school']);  
            }else{
              $schoolId = Auth::id();
            }
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
          $gender['responsible_decision_making']['Female']  = $this->Report->gender('responsible_decision_making','F',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
          $gender['relationship_skills']['Male']    = $this->Report->gender('relationship_skills','M',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
          $gender['relationship_skills']['Female']  = $this->Report->gender('relationship_skills','F',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
          $gender['social_awareness']['Male']       = $this->Report->gender('social_awareness','M',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
          $gender['social_awareness']['Female']     = $this->Report->gender('social_awareness','F',$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate);
          
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



        /***********Data to generate PDF*************************/
            if(isset($schoolId) && !empty($schoolId)){
                $schoolName = User::where("id",$schoolId)->pluck("name");
                $pdfArray['school'] = $schoolName[0];
            }else{
                $pdfArray['school'] = "";
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
                $studentGet = Student::where("id",$_GET['student'])->select("name", "last_name", "roll_number")->first();
                $studentName = trim($studentGet['name'] . " " . $studentGet['last_name']);
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
        
        return view("School.analytics",['RestorativePractice' => $RestorativePractice,'timeChart' => $timeChartForSchool,'gender' => $gender,'Behavior' => $Behavior,'locations' => $locations,'Interventions' => $Interventions,'grades' =>$getAllGrades,'students' => $getStudentsOfGrade,'pdfArray' => $pdfArray]);
   }

   /*****Show Settings*****/
   public function settings(){
       $userId            = Auth::id();
       $getDetails        = User::with('school')->where("id",$userId)->first()->toArray();
       $getAllGrades      = Grade::all();
       $getMyGradeRosters = GradeRoster::with('grades')->where(['user_id' => $userId, 'status' => '1'])->get();
       return view("School.settings",['details' => $getDetails,'grades' => $getAllGrades,'grade_rosters' => $getMyGradeRosters]);
   }

  public function deleteStudent(Request $request) {
    $userId = Auth::id();
    $res = Student::where(['id'=>$request->student_id, 'user_id'=>$userId])->update(['status'=>'0']);
    if($res) {
      $response['message'] = "Student has been deleted successfully.";
      $response['error'] = false;
    } else {
      $response['message'] = "Failed to delete student.";
      $response['error'] = true;
    }
    return Redirect::back()->with($response);
  }

  public function updateStudent(Request $request) {
    $userId = Auth::id();
    $validator = Validator::make($request->all(),[
      'first_name'     =>  'required',
      'last_name'      =>  'required',
      'roll_number'    =>  'required',
      'gender'         =>  'required',
      'grade'          =>  'required'
    ]);  

    if($validator->fails()){ 
      $messages = $validator->messages()->first();
      $response['message'] = $messages;
      $response['error'] = true;
      return Redirect::back()->with($response);
    }

    $checkGrade = GradeRoster::where(['user_id' => $userId, 'grade_id' => $request->grade])->first();
    if($checkGrade) {
      \DB::table("grade_rosters")->where("id",$checkGrade->id)->update(['status' => '1']);
      $gradeRosterId = $checkGrade->id;
    } else {
      $fileName = date("Y_m_d H_i_s").rand(0,9).".csv";
      $gradeRosterId = GradeRoster::insertGetId(['user_id' => $userId, 'grade_id' => $request->grade, 'file_name' => $fileName, 'status' => '1', 'created_at' => date("Y-m-d H:i:s")]);
    }

    $student = new Student();
    if(@$request->student_id && !empty($request->student_id)) {
      $checkStudent = Student::where(['id'=>$request->student_id, 'user_id'=>$userId])->first();
      if($checkStudent) {
        $student = Student::find($request->student_id);
      } else {
        $student->created_at = date("Y-m-d H:i:s");
      }
    } else {
      $student->created_at = date("Y-m-d H:i:s");
    }
    $student->user_id = $userId;
    $student->name = $request->first_name;
    $student->last_name = $request->last_name;
    $student->roll_number = $request->roll_number;
    $student->gender = $request->gender;
    $student->grade_id = $request->grade;
    $student->name = $request->first_name;
    $student->grade_roster_id = $gradeRosterId;
    $student->status = '1';

    if($student->save()) {
      $response['message'] = "Student details has been updated successfully.";
      $response['error'] = false;

    } else {
      $response['message'] = "Failed to update student details.";
      $response['error'] = true;
    }

    return Redirect::back()->with($response);
  }

  /*****Upload Grade Roaster(CSV file)*****/
   public function uploadGradeRoaster(Request $request){
      $userId = Auth::id();
      $grade  = $request['grade'];
      $checkGradeAlreadyAdded = GradeRoster::where(['user_id' => $userId, 'grade_id' => $grade])->first();
      if(isset($checkGradeAlreadyAdded)){
        /*return Redirect::back()->with("error","Grade roster already exist for this grade");*/
        /*Grade Exist Add new Students*/
        $gradeRosterId = $checkGradeAlreadyAdded->id;
       /*Multiple CSV files--*/
        $files =  $request['myfiles'];
         foreach($files as $file){
          /*Get CSV data*/
           $data = array_map('str_getcsv', file($file));
           if(isset($data[0]) && isset($data[0][1]) && trim($data[0][1]) == "First Name" && trim($data[0][2]) == "Last Name"){
             /*Data procced to insert*/
           }else{
             /*Invalid CSV Uploaded*/
             /*Student::where("grade_roster_id",$insertGrade)->delete();*/
             /*GradeRoster::where("id",$gradeRosterId)->delete();*/
             return Redirect::back()->with("error","Please upload valid student csv file");
           }

          \DB::table("grade_rosters")->where("id",$gradeRosterId)->update(['status' => '1', "created_at" => date('Y-m-d')]);
          $getGradeRosterStudents = Student::where(["grade_roster_id" => $gradeRosterId,'status'=>'1'])->count();
          $studentsTOSkip = $getGradeRosterStudents+1;
           /*Insert CSV Data To DB*/
           $students = array_slice($data, $studentsTOSkip);

           foreach($students as $student){
              $studentRollNo = $student[0];
              $studentName   = $student[1];
              $studentLastName   = $student[2];
              $studentGender = $student[3];
              if($studentGender == "M"){
                $gender = "M";
              }elseif($studentGender == "F"){
                $gender = "F";
              }else{
                 $gender = "M";
              }
              /*$checkAlready  = Student::where("roll_number",$studentRollNo)->where("user_id",$userId)->where('grade_id',$grade)->where("status","1")->first();
              if(empty($checkAlready)){*/
                  Student::insert(['user_id' => $userId, 'grade_id' => $grade,'grade_roster_id' => $gradeRosterId, 'name' =>  $studentName, 'last_name'=> $studentLastName, 'roll_number'=> $studentRollNo, 'gender' => $gender, 'status' => '1', 'created_at' => date("Y-m-d H:i:s")]);
              /*}else{
                  Student::where("roll_number",$studentRollNo)->update(['user_id' => $userId, 'grade_id' => $grade,'grade_roster_id' => $insertGrade, 'name' =>  $studentName, 'gender' => $gender, 'status' => '1', 'created_at' => date("Y-m-d H:i:s")]);         
              }*/
            }
        }
      }else{
        /*If grade not exist then create New Grade*/
        $fileName = date("Y_m_d H_i_s").rand(0,9).".csv";
        $insertGrade = GradeRoster::insertGetId(['user_id' => $userId, 'grade_id' => $grade, 'file_name' => $fileName, 'status' => '1', 'created_at' => date("Y-m-d H:i:s")]);
        
        /*Multiple CSV files--*/
        $files =  $request['myfiles'];
        foreach($files as $file){
          /*Get CSV data*/
           $data = array_map('str_getcsv', file($file));
           if(isset($data[0]) && isset($data[0][1]) && trim($data[0][1]) == "First Name" && trim($data[0][2]) == "Last Name"){
             /*Data procced to insert*/
           }else{
             /*Invalid CSV Uploaded*/
             /*Student::where("grade_roster_id",$insertGrade)->delete();*/
             GradeRoster::where("id",$insertGrade)->delete();
             return Redirect::back()->with("error","Please upload valid student csv file");
           }
           /*Insert CSV Data To DB*/
           $students = array_slice($data, 1);
           foreach($students as $student){
              $studentRollNo = $student[0];
              $studentName   = $student[1];
              $studentLastName   = $student[2];
              $studentGender = $student[3];
              if($studentGender == "M"){
                $gender = "M";
              }elseif($studentGender == "F"){
                $gender = "F";
              }else{
                 $gender = "M";
              }
              /*$checkAlready  = Student::where("roll_number",$studentRollNo)->where("user_id",$userId)->where('grade_id',$grade)->where("status","1")->first();
              if(empty($checkAlready)){*/
                  Student::insert(['user_id' => $userId, 'grade_id' => $grade,'grade_roster_id' => $insertGrade, 'name' =>  $studentName, 'last_name'=> $studentLastName, 'roll_number'=> $studentRollNo, 'gender' => $gender, 'status' => '1', 'created_at' => date("Y-m-d H:i:s")]);
             /* }else{
                  Student::where("roll_number",$studentRollNo)->update(['user_id' => $userId, 'grade_id' => $grade,'grade_roster_id' => $insertGrade, 'name' =>  $studentName, 'gender' => $gender, 'status' => '1', 'created_at' => date("Y-m-d H:i:s")]);         
              }*/
            }
        }
      }
      return Redirect::back()->with("success","Grade roster uploaded");
   }

    /*****Delete Roster*****/
   public function deleteRoster($id){
     /*Student::where("grade_roster_id",$id)->delete();*/
     \DB::table("grade_rosters")->where("id",$id)->update(['status' => '0']);
     /*GradeRoster::find($id)->update(['status' => '0']);*/
     return Redirect::back()->with("success","Grade roster deleted successfully");
   }

   /*****Get Students Of A Grade*****/
   public function getGradeStudents($gradeId){
     $userId = Auth::id();
     $getStudents = Student::where(['user_id' => $userId, 'grade_id' => $gradeId, 'status' => '1'])->orderBy("name","ASC")->get();
     $HTML = "";
     if(isset($getStudents) && !empty($getStudents)){
        foreach($getStudents as $student){
          $HTML .= "<option value='".$student->id."'>".$student->name." ".$student->last_name."</option>";
        }
     }
     echo $HTML;
   }

   /*****Get Gender Of A Student*****/
   public function getStudentGender($id){
      $getStudenDetails = Student::where("id",$id)->select("gender")->first();
      $gender = "";
      if(isset($getStudenDetails)){
        $gender = $getStudenDetails->gender;
      }
      echo $gender;
   }

   /*****Edit School Info*****/
   public function editSchoolInfo(Request $req){
     $userId   = Auth::id();
     $edit_for = $req['edit_for'];
     $field_change = $req['field_change'];
     if($edit_for == "school_name"){
       User::where("id",$userId)->update(['name' => $field_change]);
     }else if($edit_for == "principle_name"){
       School::where("user_id",$userId)->update(['principle_name' => $field_change]);
     }
     return Redirect::back();
   }

   /*****Change Profile Image*****/
   public function changeProfileImage(Request $request){
       if(isset($request->change_for) && $request->change_for == "A"){
            $userId = Auth::guard("admin")->id();
        }else{
            $userId = Auth::id();
        }
      if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $originalName = $image->getClientOriginalExtension();
            $name = time().rand(0,9).'.'.$originalName;
            $destinationPath = public_path('/uploads/profile_pic');
            $image->move($destinationPath, $name);
            School::where("user_id",$userId)->update(['profile_image' => $name]);
            User::where("id",$userId)->update(['profile_pic' => $name]);

        }
        return Redirect::back();
   }
    /*****Report History*****/
   public function reportHistory(Request $request){
    /***All Grades***/
    $getAllGrades = Grade::all();

    /*****If data filtered Start*****/
        $gradeId = "";$studentId="";$filterBy="";$pagination="FALSE";
        $schoolId = Auth::id();
           
        if(isset($request['grade']) && !empty(trim($request['grade']))){
            $gradeId = trim($request['grade']);
            $pagination = "TRUE";
        }
        if(isset($request['student']) && !empty(trim($request['student']))){
            $studentId = trim($request['student']);
            $pagination = "TRUE";
        }
    /*****If data filtered End*****/
    $grades   = Grade::all();
    $getStudentsOfGrade = array();
    if(isset($schoolId) && !empty(trim($schoolId)) && isset($_GET['grade']) && !empty(trim($_GET['grade']))){
            $schoolId = trim($schoolId);
            $gradeId  = trim($_GET['grade']);
            $getStudentsOfGrade = Student::where("user_id",$schoolId)->where("grade_id",$gradeId)->where('status','1')->get();
    }
    $students = $getStudentsOfGrade;
    
    if($pagination == "FALSE"){
            $getGradeHistory = $this->Report->getLastFewReports($schoolId);/*Fewer Reports*/
    }else{
      $getGradeHistory = $this->Report->reportHistory($schoolId,$gradeId,$studentId);
    }
    return view("School.report-history",compact('grades','getGradeHistory','students','pagination'));
   }
}
