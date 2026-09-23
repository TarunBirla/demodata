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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('auth.login');
        }

        $userRole = $request->user()->role_name ?? 'student';

        // Super admin and school admin have full access to all admin modules
        if (in_array($userRole, ['super_admin', 'school_admin'])) {
            return $next($request);
        }

        // Check if user's role is in the allowed list
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized for your user role.'], 403);
        }

        return redirect()->route('admin.dashboard')->with('error', 'Access restricted: Your role (' . ucfirst(str_replace('_', ' ', $userRole)) . ') does not have permission for that module.');
    }
}
