<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        return view("dashboard");
    }
    
    public function logout(Request $request)
    {
        $request->session()->flush();
        
        return redirect('/');
    }
}