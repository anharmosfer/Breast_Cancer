<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{


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


    public function login(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if(!Hash::check($request->password , $user->password)){
            return'cannot login';

        }
        // $token = $user->createToken($user->name);
        // return response()->json(['token'=>$token->plainTextToken , 'user'=>$user]);
    }
}
