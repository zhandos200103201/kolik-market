<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Feedback;

final readonly class CreateDTO
{
    public function __construct(
        public ?int $productId,
        public ?int $serviceId,
        public string $content,
        public float $score,
        public string $name,
    ) {
    }
}
