<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        // Debugging logs
        \Log::info('User Role: ' . ($user->role ?? 'No Role'));
        \Log::info('Allowed Roles: ' . implode(', ', $roles));

        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
