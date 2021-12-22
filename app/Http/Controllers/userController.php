<?php

namespace App\Http\Controllers;
use App\Models\Register;
use App\Models\Hash;
use DB;

use Illuminate\Http\Request;

class userController extends Controller
{
    //
   
    public function registerValidator(Request $request){
        $validate = $request->validate([
            'name' => "required|min:5",
            'email' => "required|email|unique:Registers,email",
            'password' => "required|min:5|max:12",
        ]);
        
        if($validate){
            $register = new Register;
            $register->name = $request->input('name');
            $register->Email = $request->input('email');
            $register->Password = md5($request->input('password'));
            $put=$register->save();
            if($put){
                return redirect("/register")->with("status","Register Successfully, Now Login");
            }
        } 
    }
    public function loginValidator(Request $request){
        $validate = $request->validate([
            'email' => "required|email",
            'password' => "required|min:5|max:12",
        ]);
        if($validate){
        $user=Register::where('email','=',$request->email)->first();
        if($user){
            $a=md5($request->password);
            $b=$user->Password;
            $c=$user->name;

            if($a == $b){
                return view('main',['users'=>$c]);
            }
            else{
                return back()->with('status','password doesnt match');
            }
        }
    }
}
    public function List(){
        $users = DB::select('select * from registers');
        
        return view('list',['users'=>$users]);
    }
}
