<?php

declare(strict_types=1);

namespace App\kolik\Support\Core\Enums;

use App\kolik\Support\Core\Traits\EnumTrait;

enum Role: string
{
    use EnumTrait;
    case SELLER = '1';
    case ADMIN = '2';
}
