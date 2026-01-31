<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // On vérifie si l'utilisateur est connecté ET s'il a le bon rôle
        if (!$request->user() || $request->user()->role !== $role) {
            // Si c'est une requête Inertia/AJAX, on renvoie une erreur 403
            // Sinon on peut rediriger vers la page d'accueil
            abort(403, "Vous n'avez pas l'autorisation d'accéder à cette page.");
        }
        return $next($request);
    }
}
