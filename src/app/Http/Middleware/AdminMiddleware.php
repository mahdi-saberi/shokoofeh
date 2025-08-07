<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // فقط ادمین و سوپر ادمین می‌توانند به پنل ادمین دسترسی داشته باشند
        if ($user->role !== 'admin' && $user->role !== 'super_admin') {
            abort(403, 'دسترسی غیرمجاز - فقط مدیران اجازه دسترسی به پنل مدیریت دارند');
        }

        return $next($request);
    }
}
