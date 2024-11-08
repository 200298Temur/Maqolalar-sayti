<?php


namespace App\Http\Middleware;

use Closure;
use App;
use Config;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->segment(1);
        if (array_search($locale, ['uz', 'en']) !== false) {
            app()->setLocale($request->segment(1));
            // dd(app()->getLocale());
        }
 
        return $next($request);
    }

}