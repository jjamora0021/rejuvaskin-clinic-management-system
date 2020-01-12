<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Session;

class DashboardController extends Controller
{
    public function index()
    {	
 		return view('pages.dashboard.dashboard');
    }
}