<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminUserId = $request->session()->get('admin_user_id');
        $adminUser = $adminUserId ? User::find($adminUserId) : null;

        if (! $adminUser || $adminUser->role !== 'admin') {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}