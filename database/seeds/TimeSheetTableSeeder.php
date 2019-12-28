<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class TimeSheetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = '5e021fa59cc90';

        $now = Carbon::now();
        $date = explode(' ', $now)[0];
        $year_date = explode('-', $date)[0].'-'.explode('-', $date)[1];

        $start = Carbon::create($now->year, $now->month, $now->day, 8, 0, 0); //set time to 08:00
  		$end = Carbon::create($now->year, $now->month, $now->day, 17, 0, 0); //set time to 18:00

    	$total_hours = ($end->diffInMinutes($start, true))/60;

    	DB::table('time_sheets')->insert([
        	[
                'id' => 1,
                'user_id' => '5e00ca3aa8a19',
                'year_date' => '2019-12',
	            'date_logged_in' => '2019-12-24',
                'time_in' => $start,
                'time_out' => $end,
                'total_hours_regular' => $total_hours,
                'total_hours_overtime' => null,
	            'created_by' => $user_id,
	            'created_at' => $now,
	            'updated_at' => $now
        	],
	    ]);
    }
}