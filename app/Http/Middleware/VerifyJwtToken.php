<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $refreshToken = $request->cookie('refresh_token');
        $sessionToken = $request->cookie('laravel_session');

        if ($refreshToken && $sessionToken) {
            try {
                $jwtSecret = config('app.jwt_secret');
                
                if (!$jwtSecret) {
                    return redirect(config('app.sso_endpoint') . '/login');
                }
                
                $tokenParts = explode('.', $refreshToken);
                $header = json_decode(base64_decode($tokenParts[0]));
                
                $algorithm = $header->alg ?? 'HS256';

                $payload = JWT::decode($refreshToken, new Key($jwtSecret, $algorithm));

                Log::info("Decoded JWT payload", ['payload' => json_decode(json_encode($payload), true)]);
                
                if ($payload) {
                    $listApplication = is_array($payload->listApplication) ? $payload->listApplication : [];
                    
                    $hasDots = in_array('Dots', $listApplication);
                    Log::info("IS", ['list' => $listApplication]);
                    
                    if (!$hasDots) {
                        Log::error("Dots application not found in listApplication");
                        return redirect(config('app.sso_endpoint') . '/login');
                    }

                    $request->attributes->set('user_payload', $payload);

                    return $next($request);
                }

                return redirect(config('app.sso_endpoint') . '/login');
            }catch (\Exception $error) {
                Log::error("Token invalid or verification failed", ['error' => $error->getMessage()]);
                return redirect(config('app.sso_endpoint') . '/login');
            }
        }

        $originalUrl = $request->fullUrl();
        $encodedUrl = base64_encode($originalUrl);
        
        $loginUrl = config('app.sso_endpoint') . '/login?redirect=' . $encodedUrl;
        
        return redirect($loginUrl)->withHeaders([
            'X-Original-URL' => $originalUrl
        ]);
    }
}