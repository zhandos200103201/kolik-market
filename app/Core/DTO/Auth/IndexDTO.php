<?php

declare(strict_types=1);

namespace App\Core\DTO\Auth;

use App\Models\User;

final readonly class IndexDTO
{
    public function __construct(
        public User $user,
        public string $token
    ){
    }
}
