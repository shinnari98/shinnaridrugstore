<?php

namespace App\Http\Middleware;

use App\Models\Orders;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class checkMyOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $order = Orders::where('id', $request->id)->first();
        if(Gate::denies('userHistory',$order)) {
            return redirect()->route('homepage');
        }
        return $next($request);
    }
}
