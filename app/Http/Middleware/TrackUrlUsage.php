<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackUrlUsage
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->route('token');
        $tokenFile = storage_path('used_tokens.txt');
        
        if (!file_exists($tokenFile)) {
            file_put_contents($tokenFile, '');
        }

        $usedTokens = file_get_contents($tokenFile);

        if (strpos($usedTokens, $token) !== false) {
            return response()->view('messages.expired');
        }

        // Mark the token as used
        file_put_contents(storage_path('used_tokens.txt'), $token . "\n", FILE_APPEND);

        return $next($request);
    }
}
