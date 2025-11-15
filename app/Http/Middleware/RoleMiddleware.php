<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Acesso negado: usuário não autenticado.');
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'Acesso negado: função não permitida.');
        }

        return $next($request);
    }
}
