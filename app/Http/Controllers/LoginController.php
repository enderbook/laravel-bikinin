<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfileModel;
use Hash;
use Session;
use Auth;

class LoginController extends Controller
{
    public function register(){
        return view ('register');
    }

    public function bikinin(){

        
     return view ('index');
    

        
    }

    public function rekrut(){
        
        $user = User::select('users.*',
        'profile.no_wa as wa_user')

        ->leftjoin('tb_profile as profile', 'users.id_user', '=', 'profile.id_user')        
        ->where('users.role','admin')->get();

        return view ('admin', compact('user'));
    }

    public function rekadmin(){

        return view ('regadmin');
    }

    public function rekrutAction(Request $request){
        $register = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'role' => $request->role,
            'status' => 3
        ]);

        Session::flash('info', 'Rekrut Berhasil');

        return redirect('/rekrut');
    }

    public function registerAction(Request $request){
        $register = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'role' => $request->role,
            'status' => 3
        ]);

        Session::flash('info', 'Register Berhasil');

        return redirect('/login');
    }

    public function login(){


        if (Auth::check()) {
            $user = Auth::user();
        
            if ($user->status == 2) {
                Auth::logout(); 
                return redirect('blokir');
            }
        
            switch ($user->role) {
                case 'admin':
                    return redirect('admin');
                case 'freelancer':
                    return redirect('freelancer');
                case 'client':
                    return redirect('client');
                default:
                    return redirect('/login'); 
            }
        
        } else {
            return view('login'); 
        }
        

       

        
    }

    public function loginAction(Request $request){
        $login = [
            'username' => $request->username,
            'password' =>$request->password,
            
        ];

        if(Auth::attempt($login)){
            $user = Auth::user();

            if($user->status != 2){
                if($user->role === 'admin'){

                    return redirect('admin');
                }    
                
                elseif($user->role === 'freelancer'){
                    
                   
                    return redirect('freelancer');

                   
                }
                elseif ($user->role === 'client') {
                    
                    return redirect('client');
                   
                }
                else{
                    return redirect ('/login');
                }
            }
            else{
                return redirect('blokir');

                Auth::logout();

            }
            
            
        }
        
        else{
            Session::flash('error', 'Username atau Password Salah!!!');
            return redirect('/login');
        }


      
        
    }


    public function logOut() {
        Auth::logout();

        return redirect('/');
    }



}
