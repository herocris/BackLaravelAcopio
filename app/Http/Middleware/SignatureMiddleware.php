<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
/////Middleware utilizado para agregar el nombre de la aplicacion a los encabezados de petición
class SignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $header = 'X-Name')
    {
        $response = $next($request);

        $response->headers->set($header, config('app.name'));

        return $response;
    }
}
