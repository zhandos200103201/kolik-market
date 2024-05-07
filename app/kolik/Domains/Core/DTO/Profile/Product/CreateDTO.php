<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Profile\Product;

final readonly class CreateDTO
{
    public function __construct(
        public string $name,
        public string $description,
        public string $photo,
        public int $price,
        public ?int $count,
        public bool $isUsed,
        public int $category_id,
        public int $manufacturer_id,
        public int $model_id,
    ) {
    }
}
