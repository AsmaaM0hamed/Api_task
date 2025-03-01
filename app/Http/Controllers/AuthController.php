<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\HandelResponseApiTrait;

class AuthController extends Controller
{
    use HandelResponseApiTrait;


    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;
            $user->token = $token;
            return $this->responseSuccess($user, 'Login successful', 200);
        }
        return $this->responseFailed('Invalid credentials', 401);
    }

    public function register(RegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($user){
            $token = $user->createToken('API Token')->plainTextToken;
            $user->token = $token;
            return $this->responseSuccess($user, 'User registered successfully', 200);
        }
        return $this->responseFailed('User not registered', 400);
    }

    public function logout(Request $request)
    {
        if($request->user()->currentAccessToken()->delete()){
            return $this->responseSuccess('Logged out', 'Logged out successfully', 200);
        }
        return $this->responseFailed('Failed to logout', 400);
    }

}
