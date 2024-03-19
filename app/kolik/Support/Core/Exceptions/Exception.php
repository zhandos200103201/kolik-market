<?php

declare(strict_types=1);

namespace App\kolik\Support\Core\Exceptions;

use Exception as BaseException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class Exception extends BaseException
{
    protected bool $visible = false;

    public function __construct(string $message, $httpCode = Response::HTTP_BAD_REQUEST, ?Throwable $previous = null)
    {
        parent::__construct($message, (int) $httpCode, $previous);
    }

    final public function isVisible(): bool
    {
        return $this->visible;
    }
}
