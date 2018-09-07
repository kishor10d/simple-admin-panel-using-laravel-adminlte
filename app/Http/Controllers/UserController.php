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

    public function create()
    {
        $roles = DB::table('tbl_roles')->where('roleId', '<>', 1)->get();

        return view("users.create", ["roles"=>$roles]);
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    public function checkEmailExists(Request $request)
    {
        $email = $request->input("email");
        $userId = $request->input("userId");

        $query = DB::table('tbl_users')->where([ ['email', '=' , $email], ['isDeleted', '=', 0] ]);
        if($userId != 0){ $query->where('userId', '!=', $userId); }
        $result = $query->first();

        $response = false;
        if(empty($result)){ $response = true; }
        else { $response = false; }

        return response()->json($response);
    }
}