<?php

use Illuminate\Database\Seeder;

class ServiceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
	        'Individual',
	        'Small Group',
	        'Principal Consultation',
	        'Staff Consultation',
	        'Observation',
	        'Class-Room Based',
	        'Assessment',
	        'Crisis Management',
	        'Parent Communication',
	        'Other'
        ];

        $i = 1;
        foreach($data as $service){
            \DB::table("locations")->where('id', $i)->update(["name" => $service, 'created_at' => date("Y-m-d H:i:s")]);
            $i++;
        }
        
    }
}
