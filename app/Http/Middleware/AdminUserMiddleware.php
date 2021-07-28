<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::find($request->user()->id);

        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => __('auth.not_allowed')], 401);
        }
        return $next($request);
    }
}
