<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function index()
    {
        return view("login");
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            redirect('/dashboard');
        }
    }

    public function loginMe(Request $request)
    {
        // dd(request()->all());
        // dd($request->input("email"));

        $request->validate([
            'email' => 'required|max:255',
            'password' => 'required',
        ]);

        $email = $request->input("email");
        $password = $request->input("password");

        $user = DB::table('tbl_users as BaseTbl')
                ->join('tbl_roles as Roles', 'Roles.roleId', '=', 'BaseTbl.roleId')
                ->select('BaseTbl.userId', 'BaseTbl.password', 'BaseTbl.name', 'BaseTbl.roleId', 'Roles.role')
                ->where([ ['BaseTbl.email', '=',  $email], ['BaseTbl.isDeleted', '=', 0]])
                ->first();
        
        if(!empty($user)){
            if(Hash::check($password, $user->password)){
                // dd($user);

                $sessionArray = array('userId'=>$user->userId,                    
                                            'role'=>$user->roleId,
                                            'roleText'=>$user->role,
                                            'name'=>$user->name,
                                            'isLoggedIn' => TRUE
                                    );

                $request->session()->put($sessionArray);

                // dd($request->session()->all());

                return redirect('/dashboard');
            }
            else {
                $request->session()->flash('error', 'Email or password mismatch');
                
                return redirect('/');
            }
        }
    }
}