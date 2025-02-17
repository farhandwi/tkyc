<?php

use Illuminate\Support\Facades\Cookie;

if (!function_exists('decodeJwtToken')) {
    /**
     * Decode JWT token from cookies.
     *
     * @return array|null
     */
    function decodeJwtToken()
    {
        $token = Cookie::get('refresh_token_cookies_tkyc');

        if (!$token) {
            return ['error' => 'Token not found', 'status' => 401];
        }

        try {
            $payload = app('tymon.jwt.provider.jwt')->decode($token, ['key' => env('JWT_SECRET')]);
            return ['payload' => $payload];
        } catch (\Exception $e) {
            return ['error' => 'Invalid token', 'status' => 400];
        }
    }
}
