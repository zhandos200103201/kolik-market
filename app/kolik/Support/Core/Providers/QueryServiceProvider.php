<?php

declare(strict_types=1);

namespace App\kolik\Support\Core\Providers;

use App\kolik\Support\Core\Contracts\Product\Query as DashboardProductQueryContract;
use App\kolik\Support\Core\Queries\Product\Query as DashboardProductQuery;
use Illuminate\Support\ServiceProvider;

final class QueryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        DashboardProductQueryContract::class => DashboardProductQuery::class,
    ];
}
