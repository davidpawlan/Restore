<?php

use Illuminate\Database\Seeder;

class ServicesShortNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
	        'IN',
            'SG',
            'PC',
            'SC',
            'OB',
            'CRB',
            'AS',
            'CM',
            'PC',
            'OT'
        ];

        $i = 1;
        foreach($data as $service){
            \DB::table("locations")->where('id', $i)
                ->update([
                    "short_name" => $service,
                    'created_at' => date("Y-m-d H:i:s")
                ]);
            $i++;
        }
    }
}
