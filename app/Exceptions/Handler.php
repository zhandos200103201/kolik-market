<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\kolik\Support\Core\Exceptions\DomainException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

final class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e) {
            if ($e instanceof DomainException) {
                return response([
                    'message' => $e->getMessage(),
                ]);
            }

            return response([
                'message' => $e->getMessage(),
            ]);
        });
    }
}
