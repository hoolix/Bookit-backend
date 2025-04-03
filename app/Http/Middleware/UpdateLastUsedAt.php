<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class UpdateLastUsedAt
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken()) {
            $accessToken = PersonalAccessToken::findToken($request->bearerToken());

            if ($accessToken) {
                // Update the `last_used_at` column with the current timestamp
                $accessToken->forceFill(['last_used_at' => now()])->save();
            }
        }

        return $next($request);
    }
}
