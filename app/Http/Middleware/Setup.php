<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Setup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if ($request->is('setup/*')) {
            if (config('app.setup_mode') === false) {
                // Do not allow access to setup after it was completed
                return redirect()->route('welcome');
            }
            // Skip check if current route targets the setup
            return $next($request);
        }
        if (config('app.setup_mode') !== false) {
            // Start the setup if it was not completed yet
            return redirect()->route('setup.start');
        }
        return $next($request);
    }
}
