<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Session;

class DashboardController extends Controller
{
    public function index()
    {
 		Session::push('user',(Auth::user())->toArray());   	
 		
 		return view('pages.dashboard.dashboard');
    }
}