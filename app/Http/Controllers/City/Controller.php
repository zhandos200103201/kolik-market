<?php

declare(strict_types=1);

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller as BaseController;
use App\Models\City;
use Illuminate\Http\JsonResponse;

final class Controller extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Categories are successfully retrieved.',
            'data' => City::all()
        ]);
    }
}
