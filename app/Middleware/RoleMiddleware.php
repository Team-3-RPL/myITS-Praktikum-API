<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        \Log::info('User:', ['user' => $user]); 
        if (!$user || $user->role !== $role) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        return $next($request);
    }


}
