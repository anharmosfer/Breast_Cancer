<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\VerifyRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $data = $request->validated();
        $user = DB::transaction(fn() => User::create($data));
        return UserResource::make($user);
    }

    public function verify(VerifyRequest $request)
    {
        $credentials = $request->validated();

        $user = User::query()->firstWhere('email', $credentials['email']);

        if (!$user||$credentials['code']!="123456") {
            return response(['message' => 'Invalid email or code'], 401);
        }
        $token = $user->createToken('AuthToken')->plainTextToken;

        return response([
            'user' => UserResource::make($user),
            'token' => $token
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->plainTextToken;

            return response([
                'user' => UserResource::make($user),
                'token' => $token
            ]);
        }

        return response(['error' => 'Unauthorized'], 401);
    }


}
