<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\VerifyRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulesPassword;



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

//==================   ForgetPassword & reset ======================

    public function forgotPassword(ForgetPasswordRequest $request)
    {
            return response()->noContent();
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message'=> 'Password reset successfully'
            ]);
        }

        return response([
            'message'=> __($status)
        ], 500);

    }

}
