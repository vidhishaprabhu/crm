<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        return response()->json([
            'message'=>'User registered successfully'

        ]);
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        $user=User::where('email',$request->email)->first();
        if(!$user || Hash::make($request->password,$user->password)){
            return ValidationException::withMessages([
                'email'=>['Invalid Credentials']

            ]);
        }
        return response()->json([
            'message'=>'User logged in successfully',
            'token'=>$user->createToken('auth_token')->plainTextToken,
            'user'=>$user,
            'role'=>$user->getRoleNames(),
            'permission'=>$user->getPermissionNames()
        ]);

    }
    public function user(Request $request){
        $user=$request->user();
        return response()->json([
                'user'=>$user,
                'roles'=>$user->getRoleNames(),
                'permissions'=>$user->getPermissionNames()
        ]);
    }
    public function logout(Request $request){
        $request->user()->delete();
        return response()->json([
            'message'=>'User logged out successfully'
        ]);
    }
}
