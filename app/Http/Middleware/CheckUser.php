<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check if user is logged in and check if user verified
        if (! Auth::guard('sanctum')->check()) {
           return $this->error('error',['data'=>'user unauthorized']);
        }
        if (is_null($request->user('sanctum')->email_verified_at)) {
            return $this->error('error',['data'=>'user is not verified']);
        }
        return $next($request);
    }
}


