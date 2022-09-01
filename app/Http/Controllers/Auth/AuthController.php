<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Hash;
use Session;
class AuthController extends Controller
{
    //
    public function login(){
        if(Auth::check()){
            if(Auth::user()->user_type == 1)
                return redirect('admin/dashboard');
            else if(Auth::user()->user_type == 0)
                return redirect('user/dashboard');
        }
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        if($validator->fails()){
            return array('status_code' => 301, 'errors' => $validator->errors());

        }else{
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['user_type'] = 2;
            $data['status'] = 1;
            $data['password'] = Hash::make($request->password);
            // dd($data);
            $user = User::insert($data);
            if($user){
                return array('status_code' => 200, 'message' => 'Registration Successfull', "redirect_url" => url('login'));
            }else{
                return redirect('register')->withErrors(['err' => ['Somethinng went wrong']], 'register');
            }
        }

    }

    public function userLogin(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required|min:6',
        ]);

        if($validator->fails()){
            return array('status_code' => 301, 'errors' => $validator->errors());
        }else{
             $data = array(
                'email' => $request->email,
                'password' => $request->password
             );
             //dd($data);
             if(Auth::attempt(['email' => $request->email,'password' => $request->password])){
                if(Auth::user()->user_type == 1)
                    return array('status_code' => 200, 'message' => 'Login Successfull', 'redirect_url' => url('admin/dashboard'));
                else if(Auth::user()->user_type == 2)
                    return array('status_code' => 200, 'message' => 'Login Successfull', 'redirect_url' => url('user/dashboard'));
             }else{
                return array('status_code' => 201, 'message' => 'Wrong email or password', 'redirect_url' => url('user/dashboard'));
             }
        }
    }

    public function dashboard(){
        if(Auth::check()){
            if(Auth::user()->user_type == 1)
                return redirect('admin/dashboard');
            else if(Auth::user()->user_type == 0)
                return redirect('user/dashboard');
        }
    }
}
