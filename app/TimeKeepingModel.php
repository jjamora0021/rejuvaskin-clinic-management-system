<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\HelperController;

use DB;

class TimeKeepingModel extends Model
{
    protected $table = 'time_sheets';

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->HelperController = new HelperController();
    }

    /**
     * [getTimeKeepingRecordsMonth description]
     * @param  [type] $user_id   [description]
     * @param  [type] $year_date [description]
     * @return [type]            [description]
     */
    public function getTimeKeepingRecordsMonth($user_id, $year_date)
    {
    	$result = (DB::table('time_sheets')
    				->where('year_date', $year_date)
    				->where('user_id', $user_id)
    				->get()
				)->toArray();

    	return $this->HelperController->objectToArray($result);
    }

    /**
     * [getLatestTimeIn description]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function getLatestTimeIn($user_id)
    {
        $latest_time_in = DB::table('time_sheets')
                            ->select('date_logged_in', 'time_in')
                            ->where('user_id',$user_id)
                            ->orderBy('date_logged_in', 'desc')
                            ->limit(1)
                            ->get();

        return $this->HelperController->objectToArray($latest_time_in);
    }

    /**
     * [getLatestTimeKeeping description]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function getLatestTimeKeeping($user_id)
    {
        $latest = DB::table('time_sheets')
                            ->select('date_logged_in', 'time_in', 'time_out')
                            ->where('user_id',$user_id)
                            ->orderBy('date_logged_in', 'desc')
                            ->limit(1)
                            ->get();

        if(!empty($latest)) {
            return $this->HelperController->objectToArray($latest)[0];
        }
        else {
            return false;
        }
    }

    /**
     * [saveTimeIn description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function saveTimeIn($data)
    {
        $time_in = '';

        if(empty($check)) {
            $time_in = DB::table('time_sheets')->insert($data);
        }
        else {
            $time_in = false;
        }

        return $time_in;
    }

    /**
     * [saveTimeOut description]
     * @param  [type] $user_id               [description]
     * @param  [type] $latest_date_logged_in [description]
     * @param  [type] $data                  [description]
     * @return [type]                        [description]
     */
    public function saveTimeOut($user_id, $latest_date_logged_in, $data)
    {
        $time_out = DB::table('time_sheets')
                    ->where('user_id', $user_id)
                    ->where('date_logged_in', $latest_date_logged_in)
                    ->update($data);
        
        return $time_out;
    }
}