<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        // Llama a la clase JwtAuth y cre una variable 
        $jwtAuth = new \JwtAuth();
        // le pasa el valor del token para decifrar 
        $checkToken = $jwtAuth->checkToken($token);

        if($checkToken){
            return $next($request);

        }else {
            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message'=> 'El usuario no esta identificado'
            );
            return response()->json($data,$data['code']);

        }




        
    }
}
