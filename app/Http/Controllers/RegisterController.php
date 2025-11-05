<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', ['title' => 'Register - LifeCareYou']);
    }
    function register(Request $request){
        // dd($request->all());
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
    
        
       
    }   
}
