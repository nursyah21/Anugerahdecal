<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index()
    {
        if(Auth::check() && Auth::user()->usertype =='user'){
            return redirect()->route('welcome');
        }
        return view('dashboard');
    }
}
