<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado.');
        }

        // Pega o usuário autenticado
        $user = Auth::user();

        // Verifica se tem alguma das roles necessárias
        if (!in_array($user->role, $roles)) {
            abort(403, 'Você não tem permissão para acessar esta página.');
        }

        return $next($request);
    }
}