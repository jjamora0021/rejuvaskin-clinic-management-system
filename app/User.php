<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Http\Controllers\HelperController;

use DB;
use Session;
use Config;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'username', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string'
    ];


    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->HelperController = new HelperController();
    }

    /**
     * [getAllUsers description]
     * @return [type] [description]
     */
    public function getAllUsers()
    {
        $users = DB::table('users')->get();

        return $this->HelperController->objectToArray($users);
    }

    /**
     * [getAllUsersWithUserIdAndName description]
     * @return [type] [description]
     */
    public function getAllUsersWithUserIdUserRoleAndName()
    {
        $staff = (DB::table('users')
                            ->select('user_id','user_role')
                            ->selectRaw("CONCAT(first_name,' ',middle_name,' ',last_name) AS staff_name")
                            ->get())->toArray();

        return $this->HelperController->objectToArray($staff);
    }

    /**
     * [showUser description]
     * @return [type] [description]
     */
    public function showUser()
    {
        $result = $this->HelperController->objectToArray((DB::table('users')->get())->toArray());

        return $result;
    }

    /**
     * [checkDatabase description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function checkDatabase($data)
    {
        $result = $this->HelperController->objectToArray((DB::table('users')
                            ->where('first_name',$data['firstname'])
                            ->where('middle_name',$data['middlename'])
                            ->where('last_name',$data['lastname'])
                            ->where('username',$data['username'])
                            ->where('email',$data['email'])
                            ->get())->toArray());

        return $result;
    }

    /**
     * [createUser description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function createUser($data)
    {
        $now = Carbon::now();
        $result = DB::table('users')->insert([
            'user_id' => $data['user_id'],
            'first_name' => $data['firstname'],
            'middle_name' => $data['middlename'],
            'last_name' => $data['lastname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'user_role' => $data['user-role'],
            'password' => bcrypt($data['password']),
            'remember_token' => $data['remember_token'],
            'created_at' => $now,
            'updated_at' => $now
        ]);

        return $result;
    }

    /**
     * [getUserDetails description]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function getUserDetails($user_id)
    {
        $result = (DB::table('users')
                    ->where('user_id',$user_id)
                    ->get())->toArray();

        return $this->HelperController->objectToArray($result)[0];
    }

    /**
     * [updateUser description]
     * @param  [type] $user_id [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    public function updateUser($user_id, $data)
    {
        $result = DB::table('users')
                    ->where('user_id',$user_id)
                    ->update($data);

        return $result;
    }

    /**
     * [deleteUser description]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function deleteUser($user_id)
    {
        $result = DB::table('users')
                    ->where('user_id',$user_id)
                    ->delete();

        return $result;
    }
}