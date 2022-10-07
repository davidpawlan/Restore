<?php

use Illuminate\Database\Seeder;

class DemoGraphicShortNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
	        'HF',
	        'HM',
	        'AAF',
	        'AAM',
	        'OF',
	        'OM'
        ];

        $i =1;
        foreach($data as $intervention){
         	\DB::table("interventions")->where('id', $i)
                ->update(
                [
                    "short_name" => $intervention,
                    'created_at' => date("Y-m-d H:i:s")
                ]
            );
            $i++;
        }
    }
}
