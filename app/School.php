<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class School extends Model
{
    public $timestamps = false;

    /*****Get Students of School*****/
    public function getSchoolStudents($userId,$grade=""){
        $students = DB::table("students")
                    ->where("user_id",$userId)
                    ->where("status","1");
        if($grade != ""){
            /*Also filter with grades--*/
            $students->where("grade_id",$grade);
        }
        $students = $students->select("id","user_id","grade_id","name","roll_number","gender");
        $students = $students->get();
        return $students;
    }
}
