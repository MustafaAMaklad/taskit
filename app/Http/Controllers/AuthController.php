<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AccessTokenResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function login(LoginRequest $request): AccessTokenResource
    {
        if (!Auth::attempt($request->only('username', 'password'))) {

            throw ValidationException::withMessages([
                'username' => __('auth.failed'),
            ]);
        }

        return AccessTokenResource::make(
            Auth::user()->createToken('personal-access-token')
        )->message(__('auth.login'));
    }

    public function logout(): JsonResponse
    {
        auth('api')->user()->currentAccessToken()->delete();

        return response()->success(__('auth.logout'));
    }
}
