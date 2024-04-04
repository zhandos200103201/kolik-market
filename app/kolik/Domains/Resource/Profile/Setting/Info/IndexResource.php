<?php

declare(strict_types=1);

namespace App\kolik\Domains\Resource\Profile\Setting\Info;

use App\Http\Resource\Resource as BaseResource;
use App\Models\User;

/**
 * @OA\Schema(
 *     schema="ProfileSettingInfoIndexResource",
 *
 *     @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Zhandos"
 *     ),
 *     @OA\Property(
 *          property="email",
 *          type="string",
 *          example="zhandos@gmail.com"
 *     ),
 *     @OA\Property(
 *          property="address",
 *          type="string",
 *          example="Almaty"
 *     ),
 *     @OA\Property(
 *          property="photo",
 *          type="string",
 *          example="base64 format images"
 *     ),
 *     @OA\Property(
 *          property="email_verified_at",
 *          type="Date",
 *          example="2024-03-27 11:38:20"
 *     )
 * )
 *
 * @mixin User
 */
final class IndexResource extends BaseResource
{
    public function getResponseArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'photo' => $this->photo,
            'email_verified_at' => $this->email_verified_at?->toDateTimeString(),
        ];
    }
}
