<?php

declare(strict_types=1);

namespace App\kolik\Domains\Resource\City;

use App\Http\Resource\Resource as BaseResource;
use App\Models\City;

/**
 * @OA\Schema(
 *     schema="CityIndexResource",
 *
 *     @OA\Property(
 *          property="city_id",
 *          type="integer",
 *          example="1"
 *     ),
 *     @OA\Property(
 *          property="city_name",
 *          type="string",
 *          example="City name"
 *     )
 * )
 *
 * @mixin City
 */
final class IndexResource extends BaseResource
{
    public function getResponseArray(): array
    {
        return [
            'city_id' => $this->city_id,
            'city_name' => $this->name,
        ];
    }
}
