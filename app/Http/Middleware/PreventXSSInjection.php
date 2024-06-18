<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventXSSInjection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = $request->all();
        array_walk_recursive(
            $data,
            fn (&$data) => $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8')
        ); 

        $request->merge($data);

        return $next($request);
    }
}
