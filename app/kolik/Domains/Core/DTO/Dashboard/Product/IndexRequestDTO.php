<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Dashboard\Product;

final readonly class IndexRequestDTO
{
    public function __construct(
        public ?int $categoryId,
        public ?int $manufacturerId,
        public ?int $modelId,
        public ?int $generationId,
        public ?string $name
    ) {
    }
}
