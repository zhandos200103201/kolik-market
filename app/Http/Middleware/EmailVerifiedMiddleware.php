<?php

namespace App\Http\Middleware;

use App\kolik\Support\Core\Exceptions\DomainException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmailVerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     *
     * @throws DomainException
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->email_verified_at === null) {
            throw new DomainException('Your email does not verified.');
        }

        return $next($request);
    }
}
