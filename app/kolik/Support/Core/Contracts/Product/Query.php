<?php

namespace App\kolik\Support\Core\Contracts\Product;

use App\kolik\Domains\Core\DTO\Dashboard\Product\IndexRequestDTO;
use Illuminate\Database\Eloquent\Builder;

interface Query
{
    public function products(IndexRequestDTO $dto): Builder;
}
