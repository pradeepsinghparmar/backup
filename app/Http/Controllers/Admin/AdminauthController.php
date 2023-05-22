<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminauthController extends Controller
{
    public function getLogin()
    {
        return view('admin.login');
    }  

    public function postLogin(Request $request){
         $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $validated = auth()->attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ],$request->password);

        if($validated){
            return redirect()->route('dashboards')->with('success','Login Successfull');
        }else{
            return redirect()->back()->with('error','Invalid credentials');
        }
    }

}