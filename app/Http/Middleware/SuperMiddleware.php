<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class SuperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role >= 1) {
            $res = new stdClass;
            $res->title = "Error";
            $res->message = "Access denied!";
            if ($request->wantsJson()) {
                return response()->json($res,500);
            }
            return redirect('/')->with("error",json_encode($res));
        }
        return $next($request);
    }
}
