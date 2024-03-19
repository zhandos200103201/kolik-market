<?php

declare(strict_types=1);

namespace App\kolik\Support\Core\Exceptions;

use App\kolik\Support\Core\Traits\ResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Throwable;

final class ExceptionParser
{
    use ResponseTrait;

    private const STRING_LIMIT_VALUE = 2097152;

    /**
     * @throws DomainException
     */
    public function report(Throwable $e): void
    {
        if ($e instanceof AuthenticationException) {
            throw new DomainException('Unauthorised.');
        }
    }
}
