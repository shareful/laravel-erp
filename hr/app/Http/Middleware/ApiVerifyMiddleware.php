<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use App\Http\Clients\UserHttpClient;

/**
 * class ApiVerifyMiddleware 
 * Middleware of api authentication
 *
 * @package App\Http\Middleware
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class ApiVerifyMiddleware 
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['status' => 'Token is Missing'], 401);
        }

        $client = new UserHttpClient($request);
        try {
            $authentic = $client->isAuthentic();
            if (!$authentic) {
                return response()->json(['status' => 'Unauthorized'], 401);
            }
        } catch (Exception $e) {
            if ($e instanceof Symfony\Component\HttpKernel\Exception\HttpException){
                return response()->json(['status' => 'Contact to User Api Failed'], 500);
            }else{
                return response()->json(json_decode($e->getMessage(), true), $e->getStatusCode());
            }
        }

        // Set user id and user info in global scope
        config(['user.id' => $client->getUserId(), 'user.info' => $client->getAuthUserInfo()]);
        
        return $next($request);
    }
}
