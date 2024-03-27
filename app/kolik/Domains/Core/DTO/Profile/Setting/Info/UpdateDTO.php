<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Profile\Setting\Info;

final readonly class UpdateDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $address,
        public string $photo
    ) {
    }
}
