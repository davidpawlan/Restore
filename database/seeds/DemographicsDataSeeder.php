<?php

use Illuminate\Database\Seeder;

class DemographicsDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
	        'Hispanic Female',
	        'Hispanic Male',
	        'AA Female',
	        'AA Male',
	        'Other Female',
	        'Other Male'
        ];

        $i =1;
        foreach($data as $intervention){
         	\DB::table("interventions")->where('id', $i)
                ->update(
                [
                    "name" => $intervention,
                    'created_at' => date("Y-m-d H:i:s")
                ]
            );
            $i++;
        }
    }
}
