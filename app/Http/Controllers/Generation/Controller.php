<?php

declare(strict_types=1);

namespace App\Http\Controllers\Generation;

use App\Http\Controllers\Controller as BaseController;
use App\Models\ModelGeneration;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class Controller extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Generation are successfully retrieved.',
            'data' => ModelGeneration::all(),
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can change the manufacturer.',
            ]);
        }

        $data = $request->validate([
            'model_id' => 'required|integer',
            'start_year' => 'required|integer',
            'end_year' => 'required|integer',
        ]);

        $newGeneration = ModelGeneration::query()->create([
            'model_id' => $data['model_id'],
            'start_year' => $data['start_year'],
            'end_year' => $data['end_year'],
        ]);

        return response()->json([
            'message' => 'New generation of the model is successfully created.',
            'data' => $newGeneration,
        ]);
    }

    public function update(ModelGeneration $generation, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can change the manufacturer.',
            ]);
        }

        $data = $request->validate([
            'model_id' => 'required|integer',
            'start_year' => 'required|integer',
            'end_year' => 'required|integer',
        ]);

        $generation->update([
            'model_id' => $data['model_id'],
            'start_year' => $data['start_year'],
            'end_year' => $data['end_year'],
        ]);

        return response()->json([
            'message' => 'Generation is successfully updated.',
            'data' => $generation,
        ]);
    }

    public function delete(ModelGeneration $generation): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can delete the generation.',
            ]);
        }

        $generation->delete();

        return response()->json([
            'message' => 'Generation is successfully deleted.',
        ]);
    }
}
