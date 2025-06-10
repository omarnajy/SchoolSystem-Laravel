<?php

namespace App\Http\Middleware;

use Closure;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
        
        $user = auth()->user();
        
        // Vérification simple sans Spatie
        if (!$user->hasRole('Admin')) {
            abort(403, 'Accès refusé - Rôle Admin requis');
        }
        
        return $next($request);
    }
}