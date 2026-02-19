<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if (auth()->check() && auth()->user()->isMember()) {
            $member = auth()->user()->member;

            // If the member is blocked, log them out
            if ($member && $member->status === 'blocked') {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('error', 'Your account has been blocked by the administrator.');
            }

            // Ensure profile is 75% complete
            if (! $member || $member->getCompletionPercentage() < 75) {
                // Allow access only to the profile edit, update, logout, and district API routes
                if (! $request->routeIs('member.profile.edit') &&
                    ! $request->routeIs('member.profile.update') &&
                    ! $request->routeIs('logout') &&
                    ! $request->routeIs('api.districts')) {
                    return redirect()->route('member.profile.edit')->with('info', 'Please complete your profile to at least 75% to access the dashboard.');
                }
            }
        }

        return $next($request);
    }
}
