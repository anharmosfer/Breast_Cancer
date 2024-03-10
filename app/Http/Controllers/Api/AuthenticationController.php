<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    // public function get(){

    //     $users = User::get();
    //     $msg = ["ok"];
    //     return response($users , $msg);
    // }


    public function registerUser(Request $request)
    {
        // Validation rules for the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'city' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'age' => 'required|integer',
            'gender' => 'required|in:ذكر,أنثى',
            'marital_status' => 'required|in:متزوج,غير متزوج',
        ]);

        // If validation fails,  return error response
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'city' => $request->city,
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
        ]);

        // Return success response
        return response()->json(['message' => 'User registered successfully'], 201);
    }

//======================================================

public function login(Request $request)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email',
        'password' => 'required|string',
        'phone' => 'required|string|max:20',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Find the user by email and phone
    $user = User::where('email', $request->email)
                ->where('phone', $request->phone)
                ->first();

    // If user not found or password doesn't match, return error response
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // If user and password match, return success response
    return response()->json(['message' => 'User logged in successfully'], 200);
}
//================================================================================

public function forgotPassword(Request $request)
{
    // Validation rules for the request
    $validator = Validator::make($request->all(), [
        'phone' => 'required|string|max:20',
    ]);

    // If validation fails, return error response
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }


    $user = User::where('phone', $request->phone)->first();


    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }


    $verificationCode = rand(100000, 999999);


    $user->verification_code = $verificationCode;
    $user->save();


    return response()->json(['verification_code' => $verificationCode], 200);
}


}
/*

public function login(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if(!Hash::check($request->password , $user->password)){
            return'cannot login';

        }
        // $token = $user->createToken($user->name);
        // return response()->json(['token'=>$token->plainTextToken , 'user'=>$user]);
    }

*/
