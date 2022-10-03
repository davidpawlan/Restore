<?php

use Illuminate\Database\Seeder;
class GradeTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data = [
	        'Kindergarten',
	        '1st grade',
	        '2nd grade',
	        '3rd grade',
	        '4th grade',
	        '5th grade',
	        '6th grade',
	        '7th grade',
	        '8th grade'
         ];

         foreach($data as $grade){
         	\DB::table("grades")->insert(["name" => $grade, 'created_at' => date("Y-m-d H:i:s")]);
         }
    }
}
