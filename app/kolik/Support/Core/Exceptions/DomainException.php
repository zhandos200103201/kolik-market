<?php

declare(strict_types=1);

namespace App\kolik\Support\Core\Exceptions;

final class DomainException extends Exception
{
    protected bool $visible = true;
}
