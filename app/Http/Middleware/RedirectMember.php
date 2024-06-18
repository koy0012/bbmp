<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectMember
{

    public const MEMBER_HOME = "/home";
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user(); 
        if(empty($user)) {
            return $next($request);
        }else if($user->role == "member") {
            return redirect(RedirectMember::MEMBER_HOME);
        } else {
            return redirect(RouteServiceProvider::HOME);
        }

        
    }
}
