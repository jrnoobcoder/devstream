<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    //
    public function dashboard(){
        if(Auth::check()){
            if(Auth::user()->user_type = 2){
                return view('users.dashboard');
            }
        }
    }
}
