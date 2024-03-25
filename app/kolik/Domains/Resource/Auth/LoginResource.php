<?php

declare(strict_types=1);

namespace App\kolik\Domains\Resource\Auth;

use App\Http\Resource\Resource;
use App\kolik\Domains\Core\DTO\Auth\Login\ResponseDTO;

/**
 * @OA\Schema(
 *     schema="AuthenticationLoginResource",
 *
 *     @OA\Property(
 *          property="user",
 *          type="string",
 *          example="Zhandos"
 *     ),
 *     @OA\Property(
 *          property="token",
 *          type="string",
 *          example="2|Cyw88IgISslutPtMv4HoDsZvcQ5mRrWrsEgWpwko6248d039"
 *     )
 * )
 *
 * @mixin ResponseDTO
 */
final class LoginResource extends Resource
{
    public function getResponseArray(): array
    {
        return [
            'user' => $this->user->name,
            'token' => $this->token,
        ];
    }
}
