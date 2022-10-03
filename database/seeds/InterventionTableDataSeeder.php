<?php

use Illuminate\Database\Seeder;
class InterventionTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
	        'Restorative Practice Only',
	        'Lunch Detention',
	        'After School Detention',
	        'Internal Suspension',
	        'External Suspension',
	        'Other'
         ];

         foreach($data as $intervention){
         	\DB::table("interventions")->insert(["name" => $intervention, 'created_at' => date("Y-m-d H:i:s")]);
         }
    }
}
