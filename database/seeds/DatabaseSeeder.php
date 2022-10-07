<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //$this->call(BehaviorTableDataSeeder::class);
		$this->call(GradeTableDataSeeder::class);
		// $this->call(InterventionTableDataSeeder::class);
		// $this->call(LocationTableDataSeeder::class);
        $this->call(ReferredNeededDataSeeder::class);
        $this->call(ServiceDataSeeder::class);
        $this->call(DemographicsDataSeeder::class);
    }
}
