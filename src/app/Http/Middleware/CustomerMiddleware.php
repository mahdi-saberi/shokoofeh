<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Allow customers and admins to access customer sections
        if ($user->isCustomer() || $user->hasAdminPrivileges()) {
            return $next($request);
        }

        abort(403, 'دسترسی محدود - این بخش فقط برای مشتریان است');
    }
}
