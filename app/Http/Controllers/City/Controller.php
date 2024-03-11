<?php

declare(strict_types=1);

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller as BaseController;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class Controller extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Cities are successfully retrieved.',
            'data' => City::all(),
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can add the city.',
            ]);
        }

        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $newCity = City::query()->create([
            'name' => $data['name'],
        ]);

        return response()->json([
            'message' => 'New city is successfully created.',
            'data' => $newCity,
        ]);
    }
}
