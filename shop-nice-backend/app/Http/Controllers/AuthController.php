<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request){
        $request -> validate([
            'name'=> 'required|string|max:255',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|min:8',
        ]);
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> Hash::make($request->password),
        ]);
        return response()->json(['message'=>'User registered successfully']);
    }
    public function login ( Request $request){
        $request->validate([
            'email'=>'required|string|email',
            'password'=> 'required|string',
        ]);
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'Invalid Credentials'],401);
        }
        $token = $user -> createToken('authToken')->plainTextToken;
        return response()->json(['access_token'=>$token, 'token_type'=>'Bearer']);
    }

    public function validateToken(Request $request)
    {
        if (Auth::guard('sanctum')->check()) {
            return response()->json([
                'message' => 'Token is valid',
                'user' => Auth::user(),
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid or expired token',
        ], 401);
    }
}
