<?php

declare(strict_types=1);

namespace App\Resource\Auth;

use App\Core\DTO\Auth\IndexDTO;
use App\Core\Resource\Resource;

/**
 * @mixin IndexDTO
 */
final class LoginResource extends Resource
{
    public function getResponseArray(): array
    {
        return [
            'user' => $this->user->name,
            'token' => $this->token,
            'token_type' => 'Bearer'
        ];
    }
}
