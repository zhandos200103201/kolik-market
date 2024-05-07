<?php

namespace App\Http\Middleware;

use App\kolik\Support\Core\Enums\Role;
use App\kolik\Support\Core\Exceptions\DomainException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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

        if ($user->role_id !== (int) Role::ADMIN->value) {
            throw new DomainException('You do not have own permission.');
        }

        return $next($request);
    }
}
