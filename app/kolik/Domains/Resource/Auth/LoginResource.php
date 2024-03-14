<?php

declare(strict_types=1);

namespace App\kolik\Domains\Resource\Auth;

use App\Http\Resource\Resource;
use App\kolik\Domains\Core\DTO\Auth\ResponseDTO;

/**
 * @mixin ResponseDTO
 */
final class LoginResource extends Resource
{
    public function getResponseArray(): array
    {
        return [
            'user' => $this->user->name,
            'token' => $this->token,
            'token_type' => 'Bearer',
        ];
    }
}
