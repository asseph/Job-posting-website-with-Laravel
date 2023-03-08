<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //show ragister form
    public function create(){
        return view('users.register');
    }

    //user store

    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'

        ]);

        //hash pass

        $formFields['password'] = bcrypt($formFields['password']);

        //save user
        $user = User::create($formFields);

        //login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and loged in');

    }

    //log out

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You loged out');
    }

    //login form


    public function login(){
        return view('users.login');

    }

    //login user

    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'

        ]);
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();  

            return redirect('/')->with('message', 'You loged in. Welcome Back');
        }

        return back()->withErrors(['email'=> 'Invalid Credentials'])->onlyInput('email');
    }

}
