<?php

use Illuminate\Database\Seeder;

class ReferredNeededDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Coping',
	        'Grief',
	        'Problem Solving',
	        'Social Communication',
	        'Perspective Taking',
	        'Family Issues',
	        'Peer Issues',
	        'Executive Functioning',
	        'Self-Regulation',
	        'Other'
        ];

        $i =1;
        foreach($data as $behaviour){
            \DB::table("behaviors")->where('id', $i)->update(["name" => $behaviour, 'created_at' => date("Y-m-d H:i:s")]);
            $i++;
        }
        
    }
}
