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
    
    public function users()
    {
        $users = DB::table('tbl_users as BaseTbl')
                ->select('BaseTbl.userId', 'BaseTbl.name', 'BaseTbl.email', 'BaseTbl.mobile', 'BaseTbl.roleId', 'BaseTbl.createdDtm', 'R.role')
                ->leftJoin('tbl_roles as R', 'BaseTbl.roleId', '=', 'R.roleId')
                ->where("BaseTbl.roleId", "<>", 1)->paginate(1);

        return view("users.index", ["users"=>$users]);
    }
}