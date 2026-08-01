<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMemberSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $memberUserId = $request->session()->get('member_user_id');
        $memberUser = $memberUserId ? User::with('member')->find($memberUserId) : null;

        if (! $memberUser || $memberUser->role !== 'member' || ! $memberUser->member || $memberUser->member->status !== 'active') {
            $request->session()->forget('member_user_id');

            return redirect()->route('member.login');
        }

        return $next($request);
    }
}
