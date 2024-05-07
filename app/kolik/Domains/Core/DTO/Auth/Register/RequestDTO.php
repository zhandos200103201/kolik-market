<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Auth\Register;

final readonly class RequestDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public string $password
    ) {
    }
}
