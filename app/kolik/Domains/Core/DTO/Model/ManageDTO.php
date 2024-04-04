<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\DTO\Model;

final readonly class ManageDTO
{
    public function __construct(
        public string $modelName,
        public int $manufacturerId,
    ) {
    }
}
