<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Se NÃO estiver logado ou NÃO for admin, manda para a home
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/');
        }

        return $next($request);
    }
}
