<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Dashboard\Product\Resource;

use Illuminate\Database\Eloquent\Collection;

final readonly class IndexResponseDTO
{
    public function __construct(
        public Collection $categories,
        public Collection $manufacturers,
        public Collection $carModels,
        public Collection $modelGenerations,
    ) {
    }
}
