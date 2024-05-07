<?php

declare(strict_types=1);

namespace App\kolik\Domains\Resource\Feedback;

use App\Http\Resource\Resource as BaseResource;
use App\Models\Feedback;

/**
 * @OA\Schema(
 *     schema="FeedbackIndexResource",
 *
 *     @OA\Property(
 *          property="feedback_id",
 *          type="integer",
 *          example="1"
 *     ),
 *     @OA\Property(
 *          property="product_id",
 *          type="integer",
 *          example="2"
 *     ),
 *     @OA\Property(
 *          property="service_id",
 *          type="integer",
 *          example="3"
 *     ),
 *     @OA\Property(
 *          property="content",
 *          type="string",
 *          example="This product is very good"
 *     ),
 *     @OA\Property(
 *          property="score",
 *          type="float",
 *          example="4.9"
 *     ),
 *     @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Zhandos"
 *     )
 * )
 *
 * @mixin Feedback
 */
final class IndexResource extends BaseResource
{
    public function getResponseArray(): array
    {
        return [
            'feedback_id' => $this->feedback_id,
            'product_id' => $this->product_id,
            'service_id' => $this->service_id,
            'content' => $this->content,
            'score' => $this->score,
            'name' => $this->name,
        ];
    }
}
