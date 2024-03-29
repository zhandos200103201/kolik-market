<?php

declare(strict_types=1);

namespace App\kolik\Domains\Resource\Profile\Product;

use App\Http\Resource\Resource as BaseResource;
use App\Models\Product;

/**
 * @OA\Schema(
 *     schema="ProfileProductIndexResource",
 *
 *     @OA\Property(
 *          property="product_name",
 *          type="string",
 *          example="Detail of something"
 *     ),
 *     @OA\Property(
 *          property="product_description",
 *          type="string",
 *          example="Product description"
 *     ),
 *     @OA\Property(
 *          property="product_category",
 *          type="string",
 *          example="Car"
 *     ),
 *     @OA\Property(
 *          property="product_owner",
 *          type="string",
 *          example="Zhandos"
 *     ),
 *     @OA\Property(
 *          property="photo",
 *          type="string",
 *          example="base64 format images"
 *     ),
 *     @OA\Property(
 *          property="price",
 *          type="integer",
 *          example="18000"
 *     ),
 *     @OA\Property(
 *          property="count",
 *          type="integer",
 *          example="base64 format images"
 *     ),
 *     @OA\Property(
 *          property="is_user",
 *          type="boolean",
 *          example="true"
 *     ),
 *     @OA\Property(
 *          property="views",
 *          type="integer",
 *          example="17"
 *     )
 * )
 *
 * @mixin Product
 */
final class IndexResource extends BaseResource
{
    public function getResponseArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->name,
            'product_description' => $this->description,
            'product_category' => $this->category?->name,
            'product_owner' => $this->user?->name,
            'photo' => $this->photo,
            'price' => $this->price,
            'count' => $this->count,
            'is_used' => $this->is_used,
            'views' => $this->views,
        ];
    }
}
