<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;

class UpdateUserLastActiveAt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        // if user is login
        if ($user instanceof User) {
            //use forceFill in update beacuse this column noy insert in $fillable
            $user->forceFill([
                'last_active_at' => Carbon::now(),

            ])->save();
        }
        return $next($request);
    }
}
