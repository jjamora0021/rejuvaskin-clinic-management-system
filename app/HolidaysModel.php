<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Http\Controllers\HelperController;

use DB;

class HolidaysModel extends Model
{
    protected $table = 'holidays';

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->HelperController = new HelperController();
    }

    /**
     * [getAllHolidays description]
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function getAllHolidays()
    {
    	$holidays = (DB::table('holidays')
    	    				->get())->toArray();

		return $this->HelperController->objectToArray($holidays);
    }

    /**
     * [deleteHoliday description]
     * @param  [type] $holiday_id [description]
     * @return [type]             [description]
     */
    public function deleteHoliday($holiday_id)
    {
    	$result = DB::table('holidays')
    				->where('id',$holiday_id)
    				->delete();

		return $result;
    }
}
