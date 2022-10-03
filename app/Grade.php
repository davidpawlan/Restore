<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = "grades";

    /***** Retrun GradeRoser for a grade*****/
    public function gradeRoser(){
    	return $this->hasOne("App\GradeRoster");
    }

}
