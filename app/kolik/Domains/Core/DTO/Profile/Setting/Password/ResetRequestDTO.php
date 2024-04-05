<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Profile\Setting\Password;

final readonly class ResetRequestDTO
{
    public function __construct(
        public string $email,
        public string $currentPasswd,
        public string $newPasswd
    ) {
    }
}
