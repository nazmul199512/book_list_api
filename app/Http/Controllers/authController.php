<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name'=> 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name'=> $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $reponse = [
          'user' => $user,
          'token' => $token,
        ];

        return response($reponse, 201);
    }


    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        
        // CHECK EMAIL
        $user = User::where('email',$fields['email'])->first();

        // CHECK PASSWORD

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message'=> 'Invalid credentials'
            ],401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $reponse = [
          'user' => $user,
          'token' => $token,
        ];

        return response($reponse, 201);
    }



    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message'=> 'logged out'
        ];
    }
}
