<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    function createUser(Request $req){

        $req->validate(['name'=>'required','email'=>'required','password'=>'required']);
        try{
            $hashedpw = Hash::make(substr($req->password,0,72));
            $newuser = User::create([
                'name'=>$req->name,
                'email'=>$req->email,
                'password'=>$hashedpw]);
            return response()->json([
                'status'=>'success',
                'message'=>'User created successfully'
            ],201);
        }
        catch(\Exception $e){
            return response()->json([
                'status'=>'false',
                'message'=>$e->getMessage()
            ],500);
        }
    }

    function loginUser(Request $req){
        $req->validate(['email'=>'required','password'=>'required']);
        try{

            $user = User::where('email',$req->email)->first();
            if(!$user){
                return response()->json(['message' => 'User not found'], 404);
            }
            if(!Hash::check(substr($req->password,0,72),$user->password)){
                return response()->json(['message' => 'Entered wrong password'], 404);
            }

            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'message' => 'Success',
                'token' => $token
            ], 200);

        }
        catch(\Exception $e){
            return response()->json([
                'status'=>'false',
                'message'=>$e->getMessage()
            ],500);
        }
    }
}
