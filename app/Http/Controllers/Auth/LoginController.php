<?php

namespace App\Http\Controllers\Auth;
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

    public function login(Request $request) {
        $this->validateLogin($request);
        
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if($this->guard()->validate($this->credentials($request))) {
            if(Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                return redirect('adm');
            }  else {
                $this->incrementLoginAttempts($request);
                return response()->json([
                    'error' => 'This account is not activated.'
                ], 401);
            }
        } else {
            // dd('ok');
            $this->incrementLoginAttempts($request);
            return response()->json([
                'error' => 'Credentials do not match our database.'
            ], 401);
        }
    }
/*
    protected function credentials(Request $request)
    {
        if(strpos($request->get('username'), "VND_") !== false)
            return ['username'=>"VND_{$request->get('username')}",'password'=>$request->get('password')];
        
        return ['username' => $request->get('username'), 'password'=>$request->get('password')];
    }*/
}
