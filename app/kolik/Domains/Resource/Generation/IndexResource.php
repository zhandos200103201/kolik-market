<?php

declare(strict_types=1);

namespace App\kolik\Domains\Resource\Generation;

use App\Http\Resource\Resource as BaseResource;
use App\Models\ModelGeneration;

/**
 * @OA\Schema(
 *     schema="ModelGenerationIndexResource",
 *
 *     @OA\Property(
 *          property="generation_id",
 *          type="integer",
 *          example="1"
 *     ),
 *     @OA\Property(
 *          property="model_id",
 *          type="integer",
 *          example="3"
 *     ),
 *     @OA\Property(
 *          property="start_year",
 *          type="integer",
 *          example="2015"
 *     ),
 *     @OA\Property(
 *          property="end_year",
 *          type="integer",
 *          example="2020"
 *     )
 * )
 *
 * @mixin ModelGeneration
 */
final class IndexResource extends BaseResource
{
    public function getResponseArray(): array
    {
        return [
            'generation_id' => $this->generation_id,
            'model_id' => $this->model_id,
            'start_year' => $this->start_year,
            'end_year' => $this->end_year,
        ];
    }
}
