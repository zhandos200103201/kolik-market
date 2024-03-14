<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Model;

use App\Http\Controllers\Controller as BaseController;
use App\Models\CarModel;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class Controller extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Model of the cars are successfully retrieved.',
            'data' => CarModel::all(),
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
            'model_name' => 'required|string',
            'manufacturer_id' => 'required|string',
        ]);

        $newModel = CarModel::query()->create([
            'name' => $data['name'],
            'manufacturer_id' => $data['manufacturer_id'],
        ]);

        return response()->json([
            'message' => 'New model of car is successfully created.',
            'data' => $newModel,
        ]);
    }

    public function update(CarModel $model, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can change the manufacturer.',
            ]);
        }

        $data = $request->validate([
            'model_name' => 'required|string',
            'manufacturer_id' => 'required|string',
        ]);

        $model->update([
            'name' => $data['name'],
            'manufacturer_id' => $data['manufacturer_id'],
        ]);

        return response()->json([
            'message' => 'Model of the car is successfully updated.',
            'data' => $model,
        ]);
    }

    public function delete(CarModel $model): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can delete the category.',
            ]);
        }

        $model->delete();

        return response()->json([
            'message' => 'Model of the car is successfully deleted.',
        ]);
    }
}
