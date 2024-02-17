<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(){
        return view('client.auth.login');
    }

    public function reset(){
        return view('client.auth.reset');
    }


    public function sendResetEmail(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if($validator->fails()){
            session()->flash('error', "Invalid email address");
            return redirect()->route('reset');
        }
        
        $email = User::where('email' , $request->email)->first();

        if(!$email){
            session()->flash('error', "The email account isn't not registered");
            return redirect()->route('reset');
        }

        $randomPassword = Str::random(8);
        $email->password = Hash::make($randomPassword);
        $email->save();

        $resetLink = $randomPassword;
        $customerName = $email->name; 

        Mail::to($email->email)->send(new ResetPasswordMail($resetLink, $customerName));

        session()->flash('message', "An email has been sent; please follow it for further information.");
        return redirect()->route('reset');

    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback(){
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user){
            $user = User::createFromGoogle($googleUser);
        }
        if(!Auth::check()){
            $isBanned = User::where('email', $googleUser->getEmail())->first();

            if($isBanned->status == 'suspended'){
                session()->flash('error', 'Account has been suspended');
                return redirect()->route('login');
            }else{
                Auth::login($user);
                $intendedUrl = session('url.intended', '/');
                if($intendedUrl){
                    session()->forget('url.intended');
                    return redirect()->to($intendedUrl);
                }

                return redirect()->route('account.index');
            }
        }


        
        return redirect()->route('account.index');
    }

    public function verifyLogin(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->first()]);
        }

        $user = User::where('email',$request->email)->first();

        if($user){
            if($user->status == 'suspended'){
                return response()->json(['status' => false, 'errors' => 'User account suspended']);
            }
        }
        

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->has('remember'))) {

            $intendedUrl = session('url.intended', '/');
            if($intendedUrl){
                session()->forget('url.intended');
                return response()->json(['status' => 'url', 'intendedUrl' => $intendedUrl]);
            }

            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false, 'errors' => 'Invalid credentials']);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('index');
    }

   


    
}
