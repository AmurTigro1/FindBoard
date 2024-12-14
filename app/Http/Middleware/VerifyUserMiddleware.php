<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Check if the user is verified (example: phone and photo verified)
        if (!$user->hasVerifiedPhone() || !$user->hasVerifiedPhoto()) {
            return redirect()->route('verification.page');
        }
        if (!$user->hasVerifiedPhoto() || !$user->hasVerifiedPhone() || !$user->hasVerifiedBusinessPermit()) {
            return redirect()->route('verification.page');
        }
        return $next($request);
    }
}
