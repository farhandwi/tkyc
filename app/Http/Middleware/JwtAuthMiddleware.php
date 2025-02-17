<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class JwtAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'error' => 'Access denied, no token provided'
            ], 401);
        }

        try {
            JWT::decode($token, new Key(config('jwt.secret'), 'HS256'));
            
            return $next($request);
            
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'Token has expired'
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Invalid token'
            ], 400);
        }
    }
}