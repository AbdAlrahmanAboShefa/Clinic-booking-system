<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectUsersWithoutRoles
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->roles()->count() === 0 && !$request->routeIs('patient.profile.*')) {
            return redirect()->route('patient.profile.create');
        }

        return $next($request);
    }
}
