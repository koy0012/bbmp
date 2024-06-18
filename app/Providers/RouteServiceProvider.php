<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/back/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('limited', function (Request $request) {
            return Limit::perMinute(30)->by("limited:{$request->ip()}");
        }); 

        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip()); 
        });

        RateLimiter::for('account', function (Request $request){
            $maxAttempts = 1; 
            $days = 30;  

            /** @var User $user */
            $user = $request->user();

            if($user->hasAnyRole(['municipal','national'])){
                return Limit::none();
            } 
 

            // return Limit::perMinutes($days * 60 * 24,$maxAttempts)->by("account:{$request->user()->id}")->response(function(Request $request, $headers) {
            //     $r = $headers['X-RateLimit-Reset']; 
            //     $time = date('Y-m-d h:ia', $r);

            //     return response()->json(
            //         ['message' => "You have already updated your account, you may change it again on {$time}"],
            //         429
            //     );
            // });
        });

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by("auth:{$request->ip()}")->response(function() {
                return response()->json(
                    ['message' => "Too many attempts, try again later."],
                    429
                );
            });
        });

        $this->routes(function () {
            Route::middleware('api', 'cors')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
