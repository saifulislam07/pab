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

            // Ensure profile is 100% complete
            if (! $member || $member->getCompletionPercentage() < 100) {
                // Allow access only to the profile edit, update, logout, and district API routes
                if (! $request->routeIs('member.profile.edit') &&
                    ! $request->routeIs('member.profile.update') &&
                    ! $request->routeIs('logout') &&
                    ! $request->routeIs('api.districts')) {
                    return redirect()->route('member.profile.edit')->with('info', 'Please complete your profile to 100% to access the dashboard.');
                }
            }
        }

        return $next($request);
    }
}
