<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    protected $role = '';
	protected $vendorId = '';
	protected $name = '';
	protected $roleText = '';
	protected $global = array ();
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {        
        if ( !($request->session()->has('isLoggedIn') && $request->session()->get('isLoggedIn') == TRUE) ) {
            return redirect('/');
        } else {
            $this->role = $request->session()->get( 'role' );
			$this->vendorId = $request->session()->get( 'userId' );
			$this->name = $request->session()->get( 'name' );
			$this->roleText = $request->session()->get( 'roleText' );
			
			$this->global ['name'] = $this->name;
			$this->global ['role'] = $this->role;
            $this->global ['role_text'] = $this->roleText;
        }
        
        if($request->path() === "/") { return redirect('/dashboard'); }

        return $next($request);
    }
}
