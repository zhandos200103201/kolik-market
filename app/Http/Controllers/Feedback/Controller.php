<?php

declare(strict_types=1);

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class Controller extends BaseController
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Feedbacks are successfully retrieved.',
            'data' => Feedback::all()
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'service_id' => 'required|integer',
            'content' => 'required|string',
            'score' => 'required|float',
        ]);

        $newFeedback = Feedback::query()->create([
            'product_id' => $data['product_id'],
            'service_id' => $data['service_id'],
            'content' => $data['content'],
            'score' => $data['score'],
        ]);

        return response()->json([
            'message' => 'You left a feedback.',
            'data' => $newFeedback
        ]);
    }
}
