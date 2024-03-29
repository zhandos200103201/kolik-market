<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Feedback;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Request\Feedback\CreateRequest;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;

final class Controller extends BaseController
{
    /**
     * @OA\Get (
     *     summary="Get user feedbacks for products",
     *     path="/feedbacks",
     *     operationId="feedback-index",
     *     tags={"feedback"},
     *     description="Get product feedbacks.",
     *     parameters={},
     *
     *     @OA\Response(
     *          response=200,
     *          description="Feedbacks are successfully retrieved.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/ProfileProductIndexResource"),
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Feedbacks are successfully retrieved.',
            'data' => Feedback::all(),
        ]);
    }

    /**
     * @OA\Post(
     *     summary="Create user feedback for products",
     *     path="/feedbacks",
     *     operationId="feedback-create",
     *     tags={"feedback"},
     *     description="Create product feedbacks.",
     *     parameters={},
     *
     *     @OA\Response(
     *          response=200,
     *          description="You left a feedback.",
     *     )
     * )
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $dto = $request->getDto();

        $newFeedback = Feedback::query()->create([
            'product_id' => $dto->productId,
            'service_id' => $dto->serviceId,
            'content' => $dto->content,
            'score' => $dto->score,
        ]);

        // Need to check for fillable

        return response()->json([
            'message' => 'You left a feedback.',
            'data' => $newFeedback,
        ]);
    }
}
