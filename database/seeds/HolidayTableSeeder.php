<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class HolidayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('holidays')->insert([
        	[
                'id' => 1,
                'holiday' => "New Year's Day",
	            'date' => '01-01',
	            'created_at' => $now,
	            'updated_at' => $now
        	],
        	[
                'id' => 2,
                'holiday' => "Chinese New Year",
	            'date' => '02-25',
	            'created_at' => $now,
	            'updated_at' => $now
        	],
	    ]);
    }
}
