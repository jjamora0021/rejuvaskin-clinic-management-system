<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TimeKeepingModel;

use Session;
use Carbon\Carbon;

class TimeKeepingController extends Controller
{
	protected $HelperController;
	protected $TimeKeepingModel;

	public function __construct()
	{
		$this->TimeKeepingModel = new \App\TimeKeepingModel;
		$this->HelperController = new HelperController();
	}

	/**
	 * [showTimeKeeping description]
	 * @return [type] [description]
	 */
    public function showTimeKeeping()
    {
    	$user_id = Session::get('user')[0]['user_id'];

    	$day_now = Carbon::now()->format('d');
    	$month_now = Carbon::now()->format('M');
    	$year_now = Carbon::now()->format('Y');
    	$number_of_days = Carbon::now()->daysInMonth;

    	$year_date = Carbon::now()->format('Y-m');

    	$records = $this->HelperController->getDate($this->TimeKeepingModel->getTimeKeepingRecordsMonth($user_id, $year_date,), $number_of_days);

    	return view('pages.dashboard.timekeeping-page', compact('user_id', 'day_now', 'month_now', 'year_now', 'number_of_days', 'records'));
    }

    /**
     * [checkTimeIn description]
     * @param  [type] $time_in [description]
     * @return [type]          [description]
     */
    public function checkTimeIn($time_in)
    {
    	if(is_null($time_in)) {
			$time_in = null;
		}
		else {
			$time_in = $time_in;
		}

		return $time_in;
    }

    /**
     * [checkTimeOut description]
     * @param  [type] $time_out [description]
     * @return [type]           [description]
     */
    public function checkTimeOut($time_out)
    {
    	if(is_null($time_out)) {
			$time_out = null;
		}
		else {
			$time_out = $time_out;
		}

		return $time_out;
    }

    /**
     * [getLatestTimeKeeping description]
     * @return [type] [description]
     */
    public function getLatestTimeKeeping()
    {
    	$user_id = Session::get('user')[0]['user_id'];

    	$latest = $this->TimeKeepingModel->getLatestTimeKeeping($user_id);
    	$date_now = Carbon::now()->format('Y-m-d');
    	
    	if($latest['date_logged_in'] == $date_now) {
    		return response()->json($latest);
    	} 
    	else {
    		return response()->json(false);
    	}
    }

    /**
     * [saveTimeIn description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function saveTimeIn(Request $request)
    {
    	$user_id = Session::get('user')[0]['user_id'];

    	$year_date = Carbon::parse($request['date'])->format('Y-m');
    	$date_logged_in = Carbon::parse($request['date'])->format('Y-m-d');
    	$time_in = $request['time'];

    	$data = [
    		'user_id' => $user_id,
    		'year_date' => $year_date,
    		'date_logged_in' => $date_logged_in,
    		'time_in' => $time_in,
    		'created_by' => Session::get('user')[0]['username'],
    		'created_at' => Carbon::now(),
    		'updated_at' => Carbon::now()
    	];

    	$save_time_in = $this->TimeKeepingModel->saveTimeIn($data);

    	return response()->json($save_time_in);
    }

    /**
     * [saveTimeOut description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function saveTimeOut(Request $request)
    {
    	$user_id = Session::get('user')[0]['user_id'];

    	$year_date = Carbon::parse($request['date'])->format('Y-m');
    	$date_logged_in = Carbon::parse($request['date'])->format('Y-m-d');
    	$time_out = $request['time'];

    	$latest_time_in = $this->TimeKeepingModel->getLatestTimeIn($user_id);

    	$start = Carbon::parse($latest_time_in[0]['date_logged_in'] . ' ' . $latest_time_in[0]['time_in']);
    	$end = Carbon::parse($date_logged_in . ' ' . $request['time']);

    	if(!empty($latest_time_in)) {
    		$total_hours = (float)($end->diffInMinutes($start, true))/60;
    		
    		$data = [
	    		'year_date' => $year_date,
	    		'date_logged_in' => $date_logged_in,
	    		'time_out' => $time_out,
	    		'total_hours_regular' => $total_hours,
	    		'updated_at' => Carbon::now()
	    	];

	    	$save_time_out = $this->TimeKeepingModel->saveTimeOut($user_id, $latest_time_in[0]['date_logged_in'], $data);

	    	if($save_time_out == true) {
	    		return response()->json($total_hours);
	    	}
	    	else {
	    		return response()->json(false);
	    	}
    	}
    	else {
    		response()->json(error);
    	}
    }
}