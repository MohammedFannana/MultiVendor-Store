<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    //  This Middleware is implement in all dashboard
    //  This Midleware to check user or admin or super-admin

    public function handle(Request $request, Closure $next): Response
    {
        // to prevent user enter dashboard

        $user = $request->user();
        // if not login
        if (!$user) {
            return redirect()->route('login');
        }

        // if user error not progress
        if ($user->type == 'user') {
            abort(403);
        }

        return $next($request);
    }
}
