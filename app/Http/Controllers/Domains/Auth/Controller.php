<?php

declare(strict_types=1);

namespace App\Http\Controllers\Domains\Auth;

use App\Core\DTO\Auth\IndexDTO;
use App\Http\Controllers\Controller as BaseController;
use App\Models\Role;
use App\Models\User;
use App\Resource\Auth\LoginResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class Controller extends BaseController
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        /** @var Role $role */
        $role = Role::query()->where('title', 'Seller')->firstOrFail();

        User::query()->insert([
            'role_id' => $role->role_id,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => true,
        ]);

        return $this->response(
            'User registered.'
        );
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($data)) {
            return response()->json([
                'message' => 'Unauthorised.',
            ], 401);
        }

        /** @var User $user */
        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;

        return $this->response(
            'User successfully logged in.',
            new LoginResource(new IndexDTO($user, $token))
        );
    }
}
