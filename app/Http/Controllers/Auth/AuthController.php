<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function getRegisterFormView()
    {
        return view('register');
    }

    public function register(RegisterRequest $registerRequest)
    {
        $data = $registerRequest->validated();
        $data['password'] = Hash::make($registerRequest->password);
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $result = DB::table('users')->insert($data);

        if ($result) {
            return redirect('/login');
        }
        else {
            return "Something went wrong";
        }
    }

    public function getLoginFormView()
    {
        return view('login');
    }

    public function login(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->validated();
        if (Auth::attempt($credentials)) {
            $loginRequest->session()->regenerate();
            return redirect('profile');
        }
        return redirect('login');
    }
}
