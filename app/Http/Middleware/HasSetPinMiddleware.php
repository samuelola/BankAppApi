<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserService;
use App\Traits\ApiResponseTrait;

class HasSetPinMiddleware
{

    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $userservice = new UserService();
        if(!$userservice->hasSetPin($user)){
            return $this->sendError("Please set pin",$statusCode=401);
        }
        return $next($request);
    }
}
