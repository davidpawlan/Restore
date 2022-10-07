<?php

use Illuminate\Database\Seeder;

class ReferredNeededShortNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'CO',
            'GR',
            'PS',
            'SC',
            'PT',
            'FI',
            'PI',
            'EF',
            'SR',
            'OT',
        ];

        $i =1;
        foreach($data as $behaviour){
            \DB::table("behaviors")->where('id', $i)
                ->update([
                    "short_name" => $behaviour, 
                    'created_at' => date("Y-m-d H:i:s")
                ]);
            $i++;
        }
    }
}
