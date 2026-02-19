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

            // If the user doesn't have a member record yet, or it's incomplete
            if (! $member || empty($member->mobile)) {
                // Allow access only to the profile edit and update routes
                if (! $request->routeIs('member.profile.edit') && ! $request->routeIs('member.profile.update') && ! $request->routeIs('logout')) {
                    return redirect()->route('member.profile.edit')->with('info', 'Please complete your profile to access the dashboard.');
                }
            }
        }

        return $next($request);
    }
}
