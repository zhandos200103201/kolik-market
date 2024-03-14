<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Manufacturer;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class Controller extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Categories are successfully retrieved.',
            'data' => Manufacturer::all(),
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can add a new manufacturer.',
            ]);
        }

        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $newManufacturer = Manufacturer::query()->create([
            'name' => $data['name'],
        ]);

        return response()->json([
            'message' => 'Manufacturer is successfully created.',
            'data' => $newManufacturer,
        ]);
    }

    public function update(Manufacturer $manufacturer, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can change the manufacturer.',
            ]);
        }
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $manufacturer->update([
            'name' => $data['name'],
        ]);

        return response()->json([
            'message' => 'Manufacturer is successfully updated.',
            'data' => $manufacturer,
        ]);
    }

    public function delete(Manufacturer $manufacturer): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can delete the manufacturer.',
            ]);
        }

        $manufacturer->delete();

        return response()->json([
            'message' => 'Manufacturer is successfully deleted.',
        ]);
    }
}
