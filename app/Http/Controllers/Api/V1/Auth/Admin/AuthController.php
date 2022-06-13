<?php

namespace App\Http\Controllers\Api\V1\Auth\Admin;

use App\Enums\UserStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {

        $guard = 'admins';

        $request->authenticate($guard);

        if ($request->user($guard)->status == UserStatus::INACTIVE) {

            throw ValidationException::withMessages([
                'email' => 'Esta cuenta ha sido desactivada, por favor póngase en contacto con el administrador.',
            ]);

        }

        $permissions = $this->getPermissions();

        $token = $request->user($guard)->createToken('asm-token', $permissions);

        return response()->json(
            [
                'user' => $request->user($guard),
                'token' => $token->plainTextToken
            ]
        );
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(
            [
                'message' => 'Logged out'
            ]
        );
    }

    public function getPermissions()
    {
        return auth('admins')->user()->roles()->with('permissions')->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('value')
            ->toArray();
    }


}
