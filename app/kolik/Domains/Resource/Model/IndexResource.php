<?php

declare(strict_types=1);

namespace App\kolik\Domains\Resource\Model;

use App\Http\Resource\Resource as BaseResource;
use App\Models\CarModel;

/**
 * @OA\Schema(
 *     schema="ModelIndexResource",
 *
 *     @OA\Property(
 *          property="model_id",
 *          type="integer",
 *          example="7"
 *     ),
 *     @OA\Property(
 *          property="model_name",
 *          type="string",
 *          example="Camry 75"
 *     ),
 *     @OA\Property(
 *          property="manufacturer_id",
 *          type="integer",
 *          example="2"
 *     )
 * )
 *
 * @mixin CarModel
 */
final class IndexResource extends BaseResource
{
    public function getResponseArray(): array
    {
        return [
            'model_id' => $this->model_id,
            'model_name' => $this->model_name,
            'manufacturer_id' => $this->manufacturer_id,
        ];
    }
}
