<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\SchedulesModel;

use Session;
use Carbon\Carbon;
use Config;

class SchedulesController extends Controller
{
	protected $HelperController;

	protected $User;
	protected $SchedulesModel;

	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		$this->HelperController = new HelperController();

		$this->User = new \App\User;
		$this->SchedulesModel = new \App\SchedulesModel;
	}

	/**
	 * [showSchedules description]
	 * @return [type] [description]
	 */
    public function showSchedules()
    {
    	$user_id = Session::get('user')[0]['user_id'];
    	$user_role = Session::get('user')[0]['user_role'];

    	$staff = $this->HelperController->getUserPermission($this->User->getAllUsersWithUserIdUserRoleAndName());
    	
    	return view('pages.dashboard.schedules', compact('user_id','user_role', 'staff'));
    }

    /**
     *  
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function saveSchedule(Request $request)
    {
    	$now = Carbon::now();
    	
    	$data = [
    		'user_id' => $request['staff'],
    		'days_working' => json_encode($request['working-days']),
    		'time_in' => Carbon::parse($request['time-in'])->format('H:i'),
    		'time_out' => Carbon::parse($request['time-out'])->format('H:i'),
    		'days_off' => json_encode($request['rest-days']),
    		'created_at' => $now,
    		'updated_at' => $now,
    	];
    	
    	$save_schedule = $this->SchedulesModel->saveSchedule($data);

    	return redirect('schedules')->with('success', 'Schedule successfully created.');
    }

    /**
     * [getStaffSchedule description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getStaffSchedule(Request $request)
    {
    	$user_id = $request['user_id'];

    	$schedule = $this->SchedulesModel->getStaffSchedule($user_id);
        
    	if(!empty($schedule)) {
    		$schedule['days_working'] = explode(',', json_decode($schedule['days_working']));
			$schedule['days_off'] = explode(',', json_decode($schedule['days_off']));
            $schedule['time_in'] = Carbon::parse($schedule['time_in'])->format('h:i A');
            $schedule['time_out'] = Carbon::parse($schedule['time_out'])->format('h:i A');

	    	return response()->json($schedule);
    	}
    	else {
    		return response()->json($schedule);
    	}
    }
}