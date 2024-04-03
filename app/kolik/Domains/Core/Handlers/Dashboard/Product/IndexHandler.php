<?php

declare(strict_types=1);

namespace App\kolik\Domains\Core\Handlers\Dashboard\Product;

use App\kolik\Domains\Core\DTO\Dashboard\Product\IndexRequestDTO;
use App\kolik\Support\Core\Contracts\Product\Query;
use Illuminate\Database\Eloquent\Collection;

final readonly class IndexHandler
{
    public function __construct(
        private Query $query
    ) {
    }

    public function handle(IndexRequestDTO $dto): Collection
    {
        return $this->query->products($dto)->get();
    }
}
