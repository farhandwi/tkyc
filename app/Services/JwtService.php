<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\MsGraphTokens;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class JwtService
{
    public function decodeToken()
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

    public function storeOrUpdateToken(string $email, string $refreshToken): array
    {
        $existingToken = MsGraphTokens::where('email', $email)->first();

        if ($existingToken) {
            $existingToken->update(['refresh_token' => $refreshToken]);

            return [
                'status' => 'updated',
                'token' => $existingToken,
            ];
        } else {
            $newToken = MsGraphTokens::create([
                'email' => $email,
                'refresh_token' => $refreshToken,
            ]);

            return [
                'status' => 'created',
                'token' => $newToken
            ];
        }
    }

    public function deleteTokenByEmail(string $email): bool
    {
        $token = MsGraphTokens::where('email', $email)->first();
        
        if ($token) {
            $token->refresh_token = null;

            return $token->save();
        }
        
        return false;
    }

    public function refresh(string $refreshToken)
    {
        try {
            // Verify and decode the refresh token using the specific refresh token key
            $decoded = JWT::decode(
                $refreshToken,
                new Key(env('JWT_REFRESH_TOKEN'), 'HS256')
            );
		Log::error(json_encode($decoded) . "====================DECODED TOKEN");
            // Validate token expiration
            if (isset($decoded->exp) && $decoded->exp < time()) {
                Log::error('Refresh token has expired');
                throw new CustomException('Token expired', 401);
            }

            // Find user
            $user = MsGraphTokens::where('email', $decoded->email)->first();
            if (!$user) {
                Log::error('User not found: ' . $decoded->email);
                throw new CustomException('User not found', 403);
            }

            $payload = [
                'email' => $decoded->email,
                'partner' => $decoded->partner,
                'cost_center' => $decoded->cost_center,
                'name' => $decoded->name,
                'job_title' => $decoded->job_title,
                'listApplication' => $decoded->listApplication,
                'iat' => time(),
                'exp' => time() + (int)env('JWT_ACCESS_TOKEN', 3600)
            ];

            // Generate new access token
            $accessToken = JWT::encode(
                $payload,
                config('jwt.secret'),
                'HS256'
            );

            return [
                'token' => $accessToken,
            ];

        } catch (\Firebase\JWT\ExpiredException $e) {
            Log::error('Token has expired: ' . $e->getMessage());
            throw new CustomException('Token expired', 401);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            Log::error('Invalid token signature: ' . $e->getMessage());
            throw new CustomException('Invalid token signature', 401);
        } catch (\Exception $e) {
            Log::error('Token refresh error: ' . $e->getMessage());
            throw new CustomException('Invalid refresh token', 401);
        }
    }
}
