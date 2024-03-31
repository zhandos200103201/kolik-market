<?php

declare(strict_types=1);

namespace App\kolik\Domains\Resource\Manufacturer;

use App\Http\Resource\Resource as BaseResource;
use App\Models\Manufacturer;

/**
 * @OA\Schema(
 *     schema="ManufacturerIndexResource",
 *
 *     @OA\Property(
 *          property="manufacturer_id",
 *          type="integer",
 *          example="1"
 *     ),
 *     @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Toyota"
 *     )
 * )
 *
 * @mixin Manufacturer
 */
final class IndexResource extends BaseResource
{
    public function getResponseArray(): array
    {
        return [
            'manufacturer_id' => $this->manufacturer_id,
            'name' => $this->name,
        ];
    }
}
