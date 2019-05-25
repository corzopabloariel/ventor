<?php

namespace App\Http\Controllers\PrivateArea;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/pedido';

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
        $this->middleware(function ($request, $next) {
            if (Auth::guard('client')->check()) {
                return redirect()->route('index');
            }
            return $next($request);
        })
        ->except('salir');
        //$this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('pedido');
        }
    }

    public function guard()
    {
        return Auth::guard('client');
    }

    public function logout(Request $request) {
        
        Auth::logout();
        return redirect()->route('index');
    }
}
