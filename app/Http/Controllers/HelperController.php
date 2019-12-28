<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Config;

class HelperController extends Controller
{
	/**
	 * [objectToArray description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
    public function objectToArray($data)
    {
        if (is_array($data) || is_object($data))
        {
            $result = array();
            foreach ($data as $key => $value)
            {
                $result[$key] = $this->objectToArray($value);
            }
            return $result;
        }
        else
        {
            return $data;
        }
    }

    /**
     * [convertToObject description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function convertToObject($data) 
    {
        $object = new \stdClass();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = $this->convertToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }

    /**
     * [getUserPermission description]
     * @param  [type] $users [description]
     * @return [type]        [description]
     */
    public function getUserPermission($users)
    {

        $users = $this->objectToArray($users);
        foreach ($users as $key => $value) {
            switch ($value['user_role']) {
                case 'superadmin':
                    $users[$key]['permission'] = 'Super Admin';
                break;
                case 'doctor':
                    $users[$key]['permission'] = 'Doctor';
                break;
                case 'manager':
                    $users[$key]['permission'] = 'Manager';
                break;
                case 'staff':
                    $users[$key]['permission'] = 'Staff Nurse';
                break;
                default:
                    $users[$key]['permission'] = 'Developer';
                break;
            }
        }
        return $users;
    }

    /**
     * [getUserRoles description]
     * @return [type] [description]
     */
    public function getUserRoles()
    {
        $roles = Config::get('roles');

        return $roles;
    }

    /**
     * [getDate description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function getDate($data, $number_of_days)
    {
        foreach ($data as $key => $value) {
            $new_key = (int)explode('-',$value['date_logged_in'])[2];
            $data[$new_key] = $value;
            unset($data[$key]);
            $data[$new_key]['date'] = (int)explode('-',$value['date_logged_in'])[2];
        }
        
        return $data;
    }

    /**
     * [getDays description]
     * @param  [type] $days [description]
     * @return [type]       [description]
     */
    public function getDays($days)
    {
        $days = explode(',', $days);
        
        foreach ($days as $key => $value) {
            $days[$key] = Config::get('days')[$value];            
        }

        return $days;
    }
}