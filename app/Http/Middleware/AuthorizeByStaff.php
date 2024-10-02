<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthorizeByStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowed_user_type = [
            User::ADMIN_USER,
            User::STAFF_USER
        ];

        if (Auth::check() && !in_array($request->user()->user_type, $allowed_user_type)) {
            return to_route('dashboard');
        }

        return $next($request);
    }
}
