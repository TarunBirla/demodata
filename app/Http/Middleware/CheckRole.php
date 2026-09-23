<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request with role-based access verification.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('auth.login');
        }

        $userRole = $request->user()->role_name ?? 'student';

        // 1. Super Admin has 100% unrestricted access across all system routes
        if ($userRole === 'super_admin') {
            return $next($request);
        }

        // 2. If a route requires super_admin exclusively (e.g. system settings), block non-super_admins
        if (in_array('super_admin', $roles) && count($roles) === 1 && $userRole !== 'super_admin') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized: Reserved exclusively for Super Admin.'], 403);
            }
            return redirect()->route('admin.dashboard')->with('error', 'Access Restricted: System Settings & Global Roles are reserved exclusively for Super Admin.');
        }

        // 3. Check if user's role is explicitly included in the allowed list
        if (!empty($roles) && in_array($userRole, $roles)) {
            return $next($request);
        }

        // 4. Default school_admin access for operational routes (if school_admin is implicitly allowed)
        if ($userRole === 'school_admin' && (empty($roles) || in_array('school_admin', $roles))) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized for your user role.'], 403);
        }

        return redirect()->route('admin.dashboard')->with('error', 'Access Restricted: Your role (' . ucfirst(str_replace('_', ' ', $userRole)) . ') does not have permission for that module.');
    }
}
