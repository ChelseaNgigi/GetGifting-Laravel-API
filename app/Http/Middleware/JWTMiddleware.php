<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
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
        $message='';

        try{
            //Checks token validation
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        }
        catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            //if token is expired
            $message='The token is expired';
        }
        catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            //if token is invalid
            $message='Invalid token';
        }
        catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            //If token is not present
            $message='Please provide a token';
        }
        return response()->json([
            'success'=>false,
            'message'=>$message
        ]);
    }
}
