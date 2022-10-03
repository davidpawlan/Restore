<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Report;
class Report extends Model
{


    public function school(){
        return $this->belongsTo("App\User","user_id","id");
    }

    public function grade(){
        return $this->belongsTo("App\Grade","grade_id","id");
    }

    public function student(){
        return $this->belongsTo("App\Student","student_id","id");
    }
    public function behaviour(){
        return $this->belongsTo("App\Behaviour","behaviour_id","id");
    }
    public function location(){
        return $this->belongsTo("App\Location","location_id","id");
    }
    public function intervention(){
        return $this->belongsTo("App\Intervention","intervention_id","id");
    }
    
    /*****Return Restorative Practice Data*****/
 public function restorativePractice($type,$schoolId="",$gradeId="",$studentId="",$timeDuration,$startDate,$endDate){

    	$getRestorativePractice = DB::table("reports")
    					->join("users","users.id","=","reports.user_id")
    					->join("students","students.id","=","reports.student_id")
    					->where("reports.status","1")
    					->where("users.status","1");
        if(isset($schoolId) && !empty($schoolId)){
            $getRestorativePractice->where("reports.user_id", $schoolId);
        }
        if(isset($gradeId) && !empty($gradeId)){
            $getRestorativePractice->where("reports.grade_id", $gradeId);
        }
        if(isset($studentId) && !empty($studentId)){
            $getRestorativePractice->where("reports.student_id", $studentId);
        }

        if(isset($timeDuration) && !empty($timeDuration)){
             $getRestorativePractice->whereBetween('reports.date', array($startDate, $endDate));
        }
        $getRestorativePractice = $getRestorativePractice->where("students.status","1");

    	$getRestorativePractice = $getRestorativePractice->avg($type);
        return $getRestorativePractice;
    }
     /*****Return Time Chart Data*****/
    public function getTimeChartForSchool($schoolId,$gradeId="",$studentId="",$filterBy){
        $getTimeChart = DB::table("reports")
                         ->join("students","students.id","=","reports.student_id")
                         ->where("reports.status","1")
                         ->where("students.status","1");
        if(isset($schoolId) && !empty($schoolId)){
            $getTimeChart->where("reports.user_id",$schoolId);
        }
        if(isset($gradeId) && !empty($gradeId)){
            $getTimeChart->where("reports.grade_id",$gradeId);
        }
        if(isset($studentId) && !empty($studentId)){
            $getTimeChart->where("reports.student_id",$studentId);
        }
        if(isset($filterBy) && !empty($filterBy)){
            $today = date("Y-m-d");
             if($filterBy == "D"){
                /*Daily Filter--*/
                $getTimeChart = $getTimeChart->where("reports.date", $today);
             }else if($filterBy == "W"){
                /*Weekly Filter--*/
                $to     = $today;
                $from   = date("Y-m-d", strtotime("-1 week"));
                $getTimeChart = $getTimeChart->whereBetween('reports.date', array($from, $to));
             }
        }

        
        $getTimeChart =  $getTimeChart->select(DB::raw("HOUR(time) as HOUR, COUNT(reports.id) AS total_reports"))
                        ->groupBy("HOUR");
        $getTimeChart = $getTimeChart->get();
        return $getTimeChart;           
    }


    /*****Return Daily Time Chart Data*****/
    public function getTimeChartForSchoolDaily($schoolId,$gradeId="",$studentId="",$filterBy){
        $filterBy = "D";
        $getTimeChart = DB::table("reports")
                         ->join("students","students.id","=","reports.student_id")
                         ->where("reports.status","1")
                         ->where("students.status","1");
        if(isset($schoolId) && !empty($schoolId)){
            $getTimeChart->where("reports.user_id",$schoolId);
        }
        if(isset($gradeId) && !empty($gradeId)){
            $getTimeChart->where("reports.grade_id",$gradeId);
        }
        if(isset($studentId) && !empty($studentId)){
            $getTimeChart->where("reports.student_id",$studentId);
        }
        if(isset($filterBy) && !empty($filterBy)){
           $today = date("Y-m-d");
           $getTimeChart->where("reports.date", $today);
        }
        $getTimeChart =  $getTimeChart->select(DB::raw("HOUR(time) as HOUR, COUNT(reports.id) AS total_reports"))
                        ->groupBy("HOUR");
        $getTimeChart = $getTimeChart->get();
        return $getTimeChart;           
    }
   /*****Return Weekly Time Chart Data*****/
    public function getTimeChartForSchoolWeekly($schoolId,$gradeId="",$studentId="",$filterBy,$startDate,$endDate){
        $filterBy = "W";
        $getTimeChart = DB::table("reports")
                         ->join("students","students.id","=","reports.student_id")
                         ->where("reports.status","1")
                         ->where("students.status","1");
        if(isset($schoolId) && !empty($schoolId)){
            $getTimeChart->where("reports.user_id",$schoolId);
        }
        if(isset($gradeId) && !empty($gradeId)){
            $getTimeChart->where("reports.grade_id",$gradeId);
        }
        if(isset($studentId) && !empty($studentId)){
            $getTimeChart->where("reports.student_id",$studentId);
        }
        if(isset($filterBy) && !empty($filterBy)){
           $getTimeChart->whereBetween('reports.date', [$startDate, $endDate]);
        }
        $getTimeChart =  $getTimeChart->select(DB::raw("reports.date as report_date, COUNT(reports.id) AS total_reports"))
                        ->groupBy("report_date");
        $getTimeChart = $getTimeChart->get();
        return $getTimeChart;           
    }

      /*****Return Monthly Time Chart Data*****/
    public function getTimeChartForSchoolMonthly($schoolId,$gradeId="",$studentId="",$filterBy,$startDate,$endDate){
        $filterBy = "M";
        $getTimeChart = DB::table("reports")
                         ->join("students","students.id","=","reports.student_id")
                         ->where("reports.status","1")
                         ->where("students.status","1");
        if(isset($schoolId) && !empty($schoolId)){
            $getTimeChart->where("reports.user_id",$schoolId);
        }
        if(isset($gradeId) && !empty($gradeId)){
            $getTimeChart->where("reports.grade_id",$gradeId);
        }
        if(isset($studentId) && !empty($studentId)){
            $getTimeChart->where("reports.student_id",$studentId);
        }
        if(isset($filterBy) && !empty($filterBy)){
           $getTimeChart->whereBetween('reports.date', [$startDate, $endDate]);
        }
        $getTimeChart =  $getTimeChart->select(DB::raw("reports.date as report_date, COUNT(reports.id) AS total_reports"))
                        ->groupBy("report_date");
        $getTimeChart = $getTimeChart->get();
        return $getTimeChart;           
    }
      /*****Return Yearly Time Chart Data*****/
    public function getTimeChartForSchoolYearly($schoolId,$gradeId="",$studentId="",$filterBy,$startDate,$endDate){
        $filterBy = "Y";
        $getTimeChart = DB::table("reports")
                         ->join("students","students.id","=","reports.student_id")
                         ->where("reports.status","1")
                         ->where("students.status","1");
        if(isset($schoolId) && !empty($schoolId)){
            $getTimeChart->where("reports.user_id",$schoolId);
        }
        if(isset($gradeId) && !empty($gradeId)){
            $getTimeChart->where("reports.grade_id",$gradeId);
        }
        if(isset($studentId) && !empty($studentId)){
            $getTimeChart->where("reports.student_id",$studentId);
        }
        if(isset($filterBy) && !empty($filterBy)){
           $getTimeChart->whereBetween('reports.date', [$startDate, $endDate]);
        }
        $getTimeChart =  $getTimeChart->select(DB::raw("MONTH(reports.date) report_month, COUNT(reports.id) AS total_reports"))
                        ->groupBy("report_month");
        $getTimeChart = $getTimeChart->get();
        return $getTimeChart;           
    }      

        /*****Return Gender Chart Data*****/
    public function gender($type,$gender,$schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate){
    	$getGenderChartData = DB::table("reports")
    					->join("users","users.id","=","reports.user_id")
    					->join("students","students.id","=","reports.student_id")
    					->where("reports.status","1")
    					->where("reports.gender","$gender")
    					->where("users.status","1")
    					->where("students.status","1");
        if(isset($schoolId) && !empty($schoolId)){
            $getGenderChartData = $getGenderChartData->where("reports.user_id", $schoolId);
        }
        if(isset($gradeId) && !empty($gradeId)){
            $getGenderChartData = $getGenderChartData->where("reports.grade_id", $gradeId);
        }
        if(isset($studentId) && !empty($studentId)){
            $getGenderChartData = $getGenderChartData->where("reports.student_id", $studentId);
        }
        if(isset($timeDuration) && !empty($timeDuration)){
            $getGenderChartData->whereBetween('reports.date', [$startDate, $endDate]);
        }

    	$getGenderChartData = $getGenderChartData->avg($type);
		return $getGenderChartData;
    }

    /*****Return Behaviour Chart Data*****/
    public function getBehaviour($schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate){
        $getBehaviour = DB::table("reports")
                            ->join("students","reports.student_id","=","students.id")
                            ->join("users","reports.user_id","=","users.id")
                            ->join("behaviors","reports.behaviour_id","=","behaviors.id")
                            ->where("users.status","1")
                            ->where("students.status","1")
                            ->where("reports.status","1");

        if(isset($schoolId) && !empty($schoolId)){
            $getBehaviour = $getBehaviour->where("reports.user_id", $schoolId);
        }
        if(isset($gradeId) && !empty($gradeId)){
            $getBehaviour = $getBehaviour->where("reports.grade_id", $gradeId);
        }
        if(isset($studentId) && !empty($studentId)){
            $getBehaviour = $getBehaviour->where("reports.student_id", $studentId);
        }
        if(isset($timeDuration) && !empty($timeDuration)){
             $getBehaviour->whereBetween('reports.date', [$startDate, $endDate]);
        }

        $getBehaviour =  $getBehaviour->select("behaviors.short_name","behaviors.name", DB::raw('count(reports.id) as behaviors_count'))
                         ->groupBy('reports.behaviour_id');
        $getBehaviour =  $getBehaviour->get();
        return  $getBehaviour;
    }

    /*****Return Locations Chart Data*****/
    public function getLocations($schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate){
        $getLocations = DB::table("reports")
                            ->join("students","reports.student_id","=","students.id")
                            ->join("users","reports.user_id","=","users.id")
                            ->join("locations","reports.location_id","=","locations.id")
                            ->where("users.status","1")
                            ->where("students.status","1")
                            ->where("reports.status","1");
        if(isset($schoolId) && !empty($schoolId)){
            $getLocations = $getLocations->where("reports.user_id", $schoolId);
        }
        if(isset($gradeId) && !empty($gradeId)){
            $getLocations = $getLocations->where("reports.grade_id", $gradeId);
        }
        if(isset($studentId) && !empty($studentId)){
            $getLocations = $getLocations->where("reports.student_id", $studentId);
        }
        if(isset($timeDuration) && !empty($timeDuration)){
            $getLocations->whereBetween('reports.date', [$startDate, $endDate]);
        }

        $getLocations =      $getLocations->select("locations.short_name", DB::raw('count(reports.id) as locations_count'))
                             ->groupBy('reports.location_id');;
        $getLocations =      $getLocations->get();
        return  $getLocations;
    }

   /*****Return Interventions Chart Data*****/
   public function getInterventions($schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate){
        $getInterventions = DB::table("reports")
                            ->join("students","reports.student_id","=","students.id")
                            ->join("users","reports.user_id","=","users.id")
                            ->join("interventions","reports.intervention_id","=","interventions.id")
                            ->where("users.status","1")
                            ->where("students.status","1")
                            ->where("reports.status","1");
        if(isset($schoolId) && !empty($schoolId)){
            $getInterventions = $getInterventions->where("reports.user_id", $schoolId);
        }
        if(isset($gradeId) && !empty($gradeId)){
            $getInterventions = $getInterventions->where("reports.grade_id", $gradeId);
        }
        if(isset($studentId) && !empty($studentId)){
            $getInterventions = $getInterventions->where("reports.student_id", $studentId);
        }
        if(isset($timeDuration) && !empty($timeDuration)){
            $getInterventions->whereBetween('reports.date', [$startDate, $endDate]);
        }

        $getInterventions = $getInterventions->select("interventions.short_name", DB::raw('count(reports.id) as interventions_count'))
                            ->groupBy('reports.intervention_id');
        $getInterventions = $getInterventions->get();
        return  $getInterventions;
    }

    /*****Return Total Number of Reports for TimePeriod*****/
    public function countTotalNumbersOfReports($schoolId,$gradeId,$studentId,$timeDuration,$startDate,$endDate){
        $getBehaviour = DB::table("reports")
                            ->join("students","reports.student_id","=","students.id")
                            ->join("users","reports.user_id","=","users.id")
                            ->join("behaviors","reports.behaviour_id","=","behaviors.id")
                            ->where("users.status","1")
                            ->where("students.status","1")
                            ->where("reports.status","1");

        if(isset($schoolId) && !empty($schoolId)){
            $getBehaviour = $getBehaviour->where("reports.user_id", $schoolId);
        }
        if(isset($gradeId) && !empty($gradeId)){
            $getBehaviour = $getBehaviour->where("reports.grade_id", $gradeId);
        }
        if(isset($studentId) && !empty($studentId)){
            $getBehaviour = $getBehaviour->where("reports.student_id", $studentId);
        }
        if(isset($timeDuration) && !empty($timeDuration)){
             $getBehaviour->whereBetween('reports.date', [$startDate, $endDate]);
        }

        $getBehaviour =  $getBehaviour->select(DB::raw('count(reports.id) as behaviors_count'));
                         
        $getBehaviour =  $getBehaviour->count();
        return  $getBehaviour;
    }


    





    /*Report History*/
    function getLastFewReports($SchoolId = ""){
         $getHistory = Report::select('id','user_id','grade_id','student_id','date','time','other_notes' ,'student as student_namee')
                        ->with("school:id,name","grade:id,name","student:id,name")
                        ->where("status",'1');
                        if(!empty($SchoolId)){
                            $getHistory->where("reports.user_id",$SchoolId);
                        }
                        $getHistory->orderBy("reports.id","DESC");
        $getHistory = $getHistory->paginate(10);
        return $getHistory;
    }


  /*Report History*/
    function reportHistory($schoolId,$gradeId,$studentId){
        $getHistory = Report::select('id','user_id','grade_id','student_id','date','time','other_notes','student as student_namee')
                        ->with("school:id,name","grade:id,name","student:id,name")
                        ->where("status",'1');
                if(isset($schoolId) && !empty($schoolId)){
                    $getHistory->where("user_id",$schoolId);
                }
                if(isset($gradeId) && !empty($gradeId)){
                    $getHistory->where("grade_id",$gradeId);
                }
                if(isset($studentId) && !empty($studentId)){
                    $getHistory->where("student_id",$studentId);
                }
                /*->whereBetween('date',['2019-07-30','2019-07-31'])*/
            $getHistory->orderBy("reports.id","DESC");
        return $getHistory = $getHistory->paginate(10);
    }



    /*****Report Details*****/
    public function reportDetails($reportId){
        $reportDetails = Report::select('id','user_id','grade_id','student_id','behaviour_id','location_id','intervention_id','self_awareness','self_management','responsible_decision_making', 'relationship_skills', 'social_awareness','gender','date','time','other_notes','student as student_namee')
                        ->with("school:id,name","grade:id,name","student:id,name","Behaviour:id,name","Location:id,name","Intervention:id,name")
                        ->where("reports.id",$reportId)
                        ->first();
        if(!empty($reportDetails)){
            $reportDetails =  $reportDetails->toArray();    
        }
        return $reportDetails;
    }

}
