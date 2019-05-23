<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/adm';

    /**
     * Check either username or email.
     * @return string
     */
    public function username()
    {
        return 'username';
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
/*
    protected function credentials(Request $request)
    {
        if(strpos($request->get('username'), "VND_") !== false)
            return ['username'=>"VND_{$request->get('username')}",'password'=>$request->get('password')];
        
        return ['username' => $request->get('username'), 'password'=>$request->get('password')];
    }*/
}
