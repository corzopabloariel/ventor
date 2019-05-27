<?php

namespace App\Http\Controllers\page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('client');
    }
    /** */
    public function logout() {
        Auth('client')::logout();
    	return redirect()->route('index');
    }

}
