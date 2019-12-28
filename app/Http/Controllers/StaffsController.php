<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use DB;
use Session;
use Carbon\Carbon;
use Redirect;
use Config;


class StaffsController extends Controller
{
    protected $HelperController;

    /**
     * [__construct description]
     */
    public function __construct()
    {
    	$this->middleware('auth');
    	$this->UserModel = new \App\User;

    	$this->HelperController = new HelperController();
    }

    /**
     * [getAllUsers description]
     * @return [type] [description]
     */
    public function getAllUsers()
    {
    	$users = $this->UserModel->getAllUsers();
    	$roles = $this->HelperController->getUserRoles();

    	foreach ($users as $key => $value) {
    		foreach ($roles as $idx => $val) {
    			if($value['user_role'] == $val['role']) {
    				$users[$key]['permission'] = $val['permission'];
    			}
    		}
    	}
    	
    	return response()->json($users);
    }

    /**
     * [showRegisterPage description]
     * @return [type] [description]bootstra
     */
    public function showUser()
    {
    	$users = $this->HelperController->getUserPermission($this->UserModel->showUser());
        foreach ($users as $key => $value) {
            if($value['user_id'] == Session::get('user')[0]['user_id']) {
                $users[$key]['disabled'] = 'disabled';
            }
            else {
                $users[$key]['disabled'] = '';   
            }
        }
        
    	return view('pages.staff.view-staff', compact('users'));
    }

    /**
     * [showCreateUser description]
     * @return [type] [description]
     */
    public function showCreateUser()
    {
    	return view('pages.staff.create-staff-profile');
    }

    /**
     * [createUser description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function createUser(Request $request)
    {
    	$firstname = $request['firstname'];
    	$middlename = $request['middlename'];
    	$lastname = $request['lastname'];
    	$username = $request['username'];
    	$email = $request['email'];
    	$user_role = $request['userrole'];

    	$token = $request['_token'];

    	$password = $request['password'];
    	$confirm_password = $request['confirm-password'];

    	$data = [
    		'user_id' => uniqid(),
    		'firstname' => $firstname,
    		'middlename' => $middlename,
    		'lastname' => $lastname,
    		'username' => $username,
    		'email' => $email,
    		'user-role' => $user_role,
    		'password' => $password,
    		'password_confirmation' => $confirm_password,
    		'remember_token' => $token
    	];
    	
    	$checkDatabase = $this->checkDatabase($data);

    	if($checkDatabase == true) {
    		$compare_password = $this->comparePasswords($password, $confirm_password);

    		if($compare_password == true) {
    			$create_user = $this->saveUser($data);

    			if($create_user == true) {
					return redirect('create-staff-profile')->with('success', 'Staff Sucessfully Created.');
		    	}
		    	else {
		    		return redirect('create-staff-profile')->with('danger', 'Please check your inputs and try again.');
		    	}
    		} 
    		else {
    			return redirect('create-staff-profile')->with('danger', 'Passwords did not match.');
    		}
    	} 
    	else {
    		return redirect('create-staff-profile')->with('danger', 'The staff already exists. Kindly check the inputs.');
    	}
    }

    /**
     * [comparePasswords description]
     * @param  [type] $password         [description]
     * @param  [type] $confirm_password [description]
     * @return [type]                   [description]
     */
    public function comparePasswords($password, $confirm_password)
    {
    	if($password === $confirm_password) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    /**
     * [checkDatabase description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function checkDatabase($data)
    {
    	$result = $this->UserModel->checkDatabase($data);

    	if(!empty($result)) {
    		return false;
    	}
    	else {
    		return true;
    	}
    }

    /**
     * [saveUser description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function saveUser($data)
    {
    	$create_user = $this->UserModel->createUser($data);
    	
    	return $create_user;
    }

    /**
     * [getUserDetails description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getUserDetails(Request $request)
    {
    	$user_details = $this->UserModel->getUserDetails($request['user_id']);
    	$roles = $this->HelperController->getUserRoles();

    	$data = [
    		'user_details' => $user_details,
    		'roles' => $roles
    	];

    	if(!empty($user_details)) {
    		return response()->json($data);
    	}
    	else {
    		return response()->json(false);
    	}
    }

    /**
     * [updateUser description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateUser(Request $request)
    {
    	$user_id = $request['user_id'];
    	$data = $request['data'];

    	$update_user = $this->UserModel->updateUser($user_id, $data);

    	return response()->json($update_user);
    }

    /**
     * [deleteUser description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteUser(Request $request)
    {
    	$user_id = $request['user_id'];

    	$delete_user = $this->UserModel->deleteUser($user_id);

    	return response()->json($delete_user);
    }
}