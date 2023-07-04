<?php

namespace App\Http\Middleware;

use App\Models\Orders;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class editProducerOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $order = Orders::where('id', $request->id)->first();
        if (Auth::user()->permission_id == 2) {
            if(Gate::denies('producerOrderEdit',$order)) {
                return redirect()->route('homepage');
            }
        }
        return $next($request);
    }
}
