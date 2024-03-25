<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Auth\Login;

use App\Models\User;

final readonly class ResponseDTO
{
    public function __construct(
        public User $user,
        public string $token
    ) {
    }
}
