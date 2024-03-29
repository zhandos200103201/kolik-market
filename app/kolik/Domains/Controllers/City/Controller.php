<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\City;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class Controller
{
    /**
     * @OA\Get(
     *     summary="User all cities.",
     *     path="/cities",
     *     operationId="citites-index",
     *     tags={"citites"},
     *     description="",
     *     parameters={},
     *
     *     @OA\Response(
     *          response=200,
     *          description="Email is successfully verified.",
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Cities are successfully retrieved.',
            'data' => City::all(),
        ]);
    }

    /**
     * @OA\Post(
     *     summary="User all cities.",
     *     path="/cities",
     *     operationId="citites-update",
     *     tags={"citites"},
     *     description="",
     *     parameters={},
     *
     *     @OA\Response(
     *          response=200,
     *          description="New city is successfully created.",
     *     )
     * )
     */
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
