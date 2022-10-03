<?php

use Illuminate\Database\Seeder;

class BehaviorTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Insubordination',
	        'Inappropriate Language',
	        'Inappropriate Contact',
	        'Fighting',
	        'Classroom Disruption',
	        'Property Infraction',
	        'Bullying',
	        'Inappropriate Attitude',
	        'Tardy/Truant',
	        'Other'
         ];

         foreach($data as $behaviour){
         	\DB::table("behaviors")->insert(["name" => $behaviour, 'created_at' => date("Y-m-d H:i:s")]);
         }
    }
}
