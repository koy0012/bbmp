<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class ParamAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission, string ...$params): Response
    { 
        $permission = is_array($permission)
            ? $permission
            : explode('|', $permission);

        $user = Auth::user();

        if(empty($user)){
            abort(403);
        }

        foreach ($params as $param) {
            foreach ($request->all() as $r1 => $r2) { 
                if(str_contains($param,"!") && empty($request->input($param))){
                    abort(403);    
                }
                
                if(strcmp($param,$r1) == 0 && !$user->canAny($permission) && !$user->hasAnyRole($permission)){
                    abort(403);
                }
            }
        } 

        return $next($request);
    }
}
