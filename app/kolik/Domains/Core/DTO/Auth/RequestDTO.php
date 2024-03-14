<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Auth;

final readonly class RequestDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {
    }
}
