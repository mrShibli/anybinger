<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{   

    public function showQuestion(){
        return view('dashboard.auth.question');
    }

    public function verifyQuestion(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6',
        ]);
        if($validator->fails()){
            return redirect()->route('secured.question')->withErrors($validator->errors());
        }

        $admin = Admin::first();
        if($admin->security_question == $request->name){
            session()->put('QuestionAns', $request->name);
            return redirect()->route('secured.login');
        }else{
            session()->flash('error', 'Wrong security question');
            return redirect()->route('secured.question');
        }
    }

    public function index(){
        
        return view('dashboard.auth.login');
    }

    public function verifyLogin(Request $request){
        // dd($request->getClientIp());

        $remember = $request->has('remember') ? true : false;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->route('secured.login')->withErrors($validator->errors())->withInput();
        }
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $remember)){

            session()->flash('success', 'You have succesfully logged in');
            return redirect()->route('secured.dashboard');
        }else{
            return redirect()->route('secured.login')->with('error', 'Invalid login credential');
        }
    }

    public function logout(){
        session()->forget('QuestionAns');
        Auth::guard('admin')->logout();
        return redirect()->route('secured.login');
    }
}
