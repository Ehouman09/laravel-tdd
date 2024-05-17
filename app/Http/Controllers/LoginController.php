<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{

    public function __invoke()
    {
        return view('auth.login');
    }
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::whereEmail($request->email)->first();

        if (! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.',
            ]);
            
        }

        Auth::login($user);

        return redirect(route('dashboard'));

    }

    public function dashboard(Request $request){
         
    }
 
}
