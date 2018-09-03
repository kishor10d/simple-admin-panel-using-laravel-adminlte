<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{    
    public function index(Request $request)
    {
        return self::isLoggedIn($request);        
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn($request)
    {
        if ( $request->session()->has('isLoggedIn') && $request->session()->get('isLoggedIn') == TRUE) {
            return redirect('/dashboard');
        } else {
            return view("login");
        }
    }

    /**
     * This function used to authenticate login user credentials
     * @param {object} $request : This is Request object
     */
    public function loginMe(Request $request)
    {
        $request->validate([
            'email' => 'required|max:255',
            'password' => 'required',
        ]);

        $email = $request->input("email");
        $password = $request->input("password");

        $user = DB::table('users as BaseTbl')
                ->join('roles as Roles', 'Roles.roleId', '=', 'BaseTbl.roleId')
                ->select('BaseTbl.userId', 'BaseTbl.password', 'BaseTbl.name', 'BaseTbl.roleId', 'Roles.role')
                ->where([ ['BaseTbl.email', '=',  $email], ['BaseTbl.isDeleted', '=', 0]])
                ->first();
        
        if(!empty($user))
        {
            if(Hash::check($password, $user->password))
            {
                $sessionArray = array('userId'=>$user->userId,                    
                                        'role'=>$user->roleId,
                                        'roleText'=>$user->role,
                                        'name'=>$user->name,
                                        'isLoggedIn' => TRUE);

                $request->session()->put($sessionArray);

                return redirect('/dashboard');
            }
            else
            {
                $request->session()->flash('error', 'Email or password missmatch');    
                return redirect('/');
            }
        }
    }
}