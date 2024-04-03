<?php

declare(strict_types=1);

namespace App\kolik\Domains\Resource\Dashboard\Product\Resource;

use App\Http\Resource\Resource as BaseResource;
use App\kolik\Domains\Core\DTO\Dashboard\Product\Resource\IndexResponseDTO;
use App\kolik\Domains\Resource\Category\IndexResource as CategoryResource;
use App\kolik\Domains\Resource\Generation\IndexResource as GenerationResource;
use App\kolik\Domains\Resource\Manufacturer\IndexResource as ManufacturerResource;
use App\kolik\Domains\Resource\Model\IndexResource as ModelResource;

/**
 * @OA\Schema(
 *     schema="DashboardProductIndexResource",
 *
 *     @OA\Property(
 *          property="categories",
 *          type="array",
 *
 *          @OA\Items(ref="#/components/schemas/CategoryIndexResource")
 *     ),
 *
 *     @OA\Property(
 *          property="manufacturer",
 *          type="array",
 *
 *          @OA\Items(ref="#/components/schemas/ManufacturerIndexResource")
 *     ),
 *
 *     @OA\Property(
 *          property="car_models",
 *          type="array",
 *
 *          @OA\Items(ref="#/components/schemas/ModelIndexResource")
 *     ),
 *
 *     @OA\Property(
 *          property="generations",
 *          type="array",
 *
 *          @OA\Items(ref="#/components/schemas/ModelGenerationIndexResource")
 *     )
 * )
 *
 * @mixin IndexResponseDTO
 */
final class IndexResource extends BaseResource
{
    public function getResponseArray(): array
    {
        return [
            'categories' => CategoryResource::collection($this->categories),
            'manufacturer' => ManufacturerResource::collection($this->manufacturers),
            'car_models' => ModelResource::collection($this->carModels),
            'generations' => GenerationResource::collection($this->modelGenerations),
        ];
    }
}
