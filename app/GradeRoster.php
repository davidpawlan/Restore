<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeRoster extends Model
{
    protected $table = "grade_rosters";

    /*****Grade rosert belongs to user*****/
    public function user(){
    	return $this->belongsTo("App\User");
    }
    /*****Grade rosert belongs to grade*****/
    public function grades(){
    	return $this->belongsTo("App\Grade","grade_id");
    }
}
