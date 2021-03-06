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
		$this->call(CreateUserTableSeeder::class);
        $this->call(TimeSheetTableSeeder::class);
        $this->call(HolidayTableSeeder::class);
    }
}
