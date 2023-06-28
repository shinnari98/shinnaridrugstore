<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        // dd($response->getStatusCode());
        if (empty($_SERVER['HTTP_REFERER']) || $request->session()->has('status')) {
            return redirect()->route('homepage');
        }
        if (empty($_SERVER['HTTP_REFERER']) || $request->session()->has('status_payment')) {
            return redirect()->route('homepage');
        }

        if (empty($_SERVER['HTTP_REFERER']) || $request->session()->has('status_orderFail')) {
            return redirect()->route('homepage');
        }
        // if(!$request->hasHeader('referer') || empty($request->header('referer'))) {
        //     return redirect()->route('homepage');
        // }
        return $next($request);
    }
}
