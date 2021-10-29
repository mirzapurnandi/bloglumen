<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next, ...$levels)
    {
        if (in_array(Auth::user()->level, $levels)) {
            $response = $next($request);
            return $response;
        }
        return response()->json([
            'status' => false,
            'message' => 'Anda tidak memiliki hak akses'
        ], 500);
    }
}
