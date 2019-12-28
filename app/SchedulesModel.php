<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\SchedulesModel;

use App\Http\Controllers\HelperController;

use DB;
use Session;
use Config;
use Carbon\Carbon;

class SchedulesModel extends Model
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->HelperController = new HelperController();
    }

    /**
     * [saveSchedule description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function saveSchedule($data)
    {
    	$save = DB::table('schedules')->insert($data);

    	return $save;
    }

    /**
     * [getAllSchedules description]
     * @return [type] [description]
     */
    public function getAllSchedules()
    {
        $schedules = (DB::table('schedules')
                        ->join('users', 'users.user_id', '=', 'schedules.user_id')
                        ->select(
                            'schedules.user_id',
                            'schedules.days_working',
                            'schedules.time_in',
                            'schedules.time_out',
                            'schedules.days_off',
                        )
                        ->selectRaw("CONCAT(users.first_name,' ',users.middle_name,' ',users.last_name) AS staff_name")
                        ->get())->toArray();

        return $this->HelperController->objectToArray($schedules);
    }

    /**
     * [getStaffSchedule description]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function getStaffSchedule($user_id)
    {
        $result = (DB::table('schedules')->where('user_id',$user_id)->get())->toArray();

        if(!empty($result)) {
            return $this->HelperController->objectToArray($result[0]);
        }
        else {
            return $result;
        }
    }
}