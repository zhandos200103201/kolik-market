<?php

declare(strict_types=1);

namespace App\kolik\Support\Core\Queries\Product;

use App\kolik\Domains\Core\DTO\Dashboard\Product\IndexRequestDTO;
use App\kolik\Support\Core\Contracts\Product\Query as QueryContract;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class Query implements QueryContract
{
    public function products(IndexRequestDTO $dto): Builder
    {
        $key = sprintf('%%%s%%', Str::lower($dto->name));

        return Product::query()
            ->when($dto->name, function ($query) use ($key) {
                $query
                    ->where(DB::raw('lower(name)'), 'like', $key)
                    ->orWhere(DB::raw('lower(description)'), 'like', $key);
            })
            ->when($dto->manufacturerId, function ($query) use ($dto) {
                $query->where('manufacturer_id', $dto->manufacturerId);
            })
            ->when($dto->generationId, function ($query) use ($dto) {
                $query->where('generation_id', $dto->generationId);
            })
            ->when($dto->categoryId, function ($query) use ($dto) {
                $query->where('category_id', $dto->categoryId);
            })
            ->when($dto->modelId, function ($query) use ($dto) {
                $query->where('model_id', $dto->modelId);
            });
    }
}
