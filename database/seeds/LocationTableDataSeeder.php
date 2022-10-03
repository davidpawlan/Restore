<?php

use Illuminate\Database\Seeder;
class LocationTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data = [
	        'Classroom',
	        'Playground',
	        'Cafeteria',
	        'Gym',
	        'Hallway',
	        'Common Area',
	        'Bathroom',
	        'Library',
	        'Bus',
	        'Other'
         ];

         foreach($data as $location){
         	\DB::table("locations")->insert(["name" => $location, 'created_at' => date("Y-m-d H:i:s")]);
         }
    }
}
