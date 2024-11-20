<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }
    public function loginproses(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        $data = [
            'email'=> $request->email,
            'password'=> $request->password
        ];

        if(Auth::attempt($data)){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('login')->with('failed','Email atau Password Salah');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('sukses', 'Kamu Berhasil Logout');
    }

    public function register(){
        return view('auth.register');
    }

    public function registerproses(Request $request){
        $request->validate([
            'nama'=>'required',
            'email'=>'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $data ['name'] = $request->nama;
        $data ['email'] = $request->email;
        $data ['password'] = Hash::make($request->password) ;

        User::create($data);
        $login = [
            'email'=> $request->email,
            'password'=> $request->password
        ];

        if(Auth::attempt($login)){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('login')->with('failed','Email atau Password Salah');
        }
    }

}
