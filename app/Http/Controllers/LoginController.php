<?php

namespace App\Http\Controllers;

use App\User;
use App\VerifyUser;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Carbon\Carbon;

class LoginController extends Controller
{

    public function login(Request $request){
        // dd($request);
        if(Auth::attempt($request->only('email', 'password'))){ 
            if(auth()->user()->level == 0){
                return \redirect(route('index'))->with('success','Berhasil Login');
            }else if(auth()->user()->level == 1){
                return \redirect(route('index'))->with('success','Berhasil Login');
            }else{                
                return \redirect(route('index'));
            }
            
        }else{
            return \redirect()->back()->with('error','Username atau Password Salah!');
        }
    
    }

    public function logout(Request $request){
        Auth::logout();
        
        return \redirect(route('index'))->with('success','Anda berhasil logout!');
    }

    public function bcrypt_gen(){
        // $x = password_hash('7471010108970002', PASSWORD_DEFAULT);
        // $y = password_verify('7471010108970002', '$2y$10$5WclQlqzaU099C7ngRrC5.bHEG4i3n9GjA4M3P89H3fHTwO05ycwu');
        $x = bcrypt('bungku_barat');
        dd($x);
    }
}
