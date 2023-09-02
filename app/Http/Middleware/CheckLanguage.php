<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;



class CheckLanguage
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //check lanuguage in header
        if (! $request->hasHeader('Accept-Language')) {
            return $this->error('missed language',['Accept-Language'=>'missed key in header']);
        }
        // //check language is supported or not

        if (! in_array($request->header('Accept-Language'),config('app.supported-languages'))) {
            return $this->error('not supported language',['language'=>'not supported lang']);

        }

        //all true
        //change language


        App::setLocale($request->header('Accept-Language'));


        return $next($request);
    }
}
