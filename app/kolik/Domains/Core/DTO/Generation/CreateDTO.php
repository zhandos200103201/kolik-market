<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Generation;

final readonly class CreateDTO
{
    public function __construct(
        public int $modelId,
        public int $startYear,
        public int $endYear,
    ) {
    }
}
