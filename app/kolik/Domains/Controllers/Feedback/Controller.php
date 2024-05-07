<?php

declare(strict_types=1);

namespace App\kolik\Domains\Controllers\Feedback;

use App\Http\Controllers\Controller as BaseController;
use App\kolik\Domains\Request\Feedback\CreateRequest;
use App\kolik\Domains\Resource\Feedback\IndexResource;
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
     *          @OA\JsonContent(ref="#/components/schemas/FeedbackIndexResource"),
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return $this->response(
            'Feedbacks are successfully retrieved.',
            IndexResource::collection(Feedback::all())
        );
    }

    /**
     * @OA\Post(
     *     summary="Create user feedback for products",
     *     path="/feedbacks",
     *     operationId="feedback-create",
     *     tags={"feedback"},
     *     description="Create product feedbacks.",
     *     parameters={
     *       {"name": "product_id", "in":"header", "type":"integer", "required":true, "description":"Product Id"},
     *       {"name": "service_id", "in":"header", "type":"integer", "required":true, "description":"Service ID"},
     *       {"name": "content", "in":"header", "type":"string", "required":true, "description":"Content of feedback"},
     *       {"name": "score", "in":"header", "type":"float", "required":true, "description":"Score of service or product"},
     *      },
     *
     *     @OA\RequestBody(
     *
     *           @OA\MediaType(
     *               mediaType="application/json",
     *
     *               @OA\Schema(ref="#/components/schemas/FeedbackCreateRequest")
     *           )
     *       ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="You left a feedback.",
     *
     *          @OA\JsonContent(ref="#/components/schemas/FeedbackIndexResource"),
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
            'name' => $dto->name,
        ]);

        return $this->response(
            'You left a feedback.',
            new IndexResource($newFeedback)
        );
    }
}
