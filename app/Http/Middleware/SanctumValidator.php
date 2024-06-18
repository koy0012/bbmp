<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

//alternative checker for sanctum
class SanctumValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    { 
        $token = explode("|", $request->bearerToken()); 

        if (!is_numeric($token[0]) || count($token) != 2) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized token'
            ]);
        }

        $ownership = PersonalAccessToken::findToken($token[1]);

        if (empty($ownership)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized token'
            ]);
        }

        return $next($request);
    }
}
