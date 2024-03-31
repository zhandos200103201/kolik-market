<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Category;

final readonly class ManageDTO
{
    public function __construct(
        public string $name,
        public string $description
    ) {
    }
}
