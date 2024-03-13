<?php

declare(strict_types=1);

namespace App\Http\Controllers\Domains\Category;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Category;
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
            'data' => Category::all(),
        ]);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json([
            'message' => 'Category is successfully retrieved.',
            'data' => $category,
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $newCategory = Category::query()->create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        return response()->json([
            'message' => 'Category is successfully created.',
            'data' => $newCategory,
        ]);
    }

    public function update(Category $category, Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $category->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        return response()->json([
            'message' => 'Category is successfully updated.',
            'data' => $category,
        ]);
    }

    public function delete(Category $category): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role_id !== 2) {
            return response()->json([
                'message' => 'Only admins can delete the category.',
            ]);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category is successfully deleted.',
        ]);
    }
}
