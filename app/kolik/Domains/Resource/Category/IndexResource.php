<?php

declare(strict_types=1);

namespace App\kolik\Domains\Resource\Category;

use App\Http\Resource\Resource as BaseResource;
use App\Models\Category;

/**
 * @OA\Schema(
 *     schema="CategoryIndexResource",
 *
 *     @OA\Property(
 *          property="category_id",
 *          type="integer",
 *          example="1"
 *     ),
 *     @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Name category"
 *     ),
 *     @OA\Property(
 *          property="description",
 *          type="string",
 *          example="Description of category"
 *     )
 * )
 *
 * @mixin Category
 */
final class IndexResource extends BaseResource
{
    public function getResponseArray(): array
    {
        return [
            'category_id' => $this->category_id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
