<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class checkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // $user = Auth::user();
        // if ($user->permission_id == 1) {
        //     return $next($request);
        // }
        if (Gate::allows('isAdmin')) {
            return $next($request);
        }

        // Xử lý trường hợp người dùng không có quyền admin
        abort(403, 'Unauthorized');
    }
}
