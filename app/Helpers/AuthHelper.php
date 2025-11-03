<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthHelper
{
    /**
     * Get the backend API URL
     */
    public static function getBackendUrl(): string
    {
        return env('BACKEND_API_URL', 'http://localhost:8000');
    }

    /**
     * Get the auth token from session
     */
    public static function getToken(): ?string
    {
        return session('auth_token');
    }

    /**
     * Get the authenticated user from session
     */
    public static function getUser(): ?array
    {
        return session('user');
    }

    /**
     * Check if user is authenticated
     */
    public static function isAuthenticated(): bool
    {
        return !empty(self::getToken());
    }

    /**
     * Set auth token and user in session
     */
    public static function setAuth(string $token, array $user): void
    {
        session(['auth_token' => $token]);
        session(['user' => $user]);
    }

    /**
     * Clear auth session
     */
    public static function clearAuth(): void
    {
        session()->forget('auth_token');
        session()->forget('user');
    }

    /**
     * Make request to backend API
     * @param string $method HTTP method (GET, POST, PUT, DELETE, PATCH)
     * @param string $endpoint API endpoint
     * @param array $data Request data
     * @param bool $isProtected Whether the request requires authentication (default: true)
     * @return \Illuminate\Http\Client\Response
     */
    public static function apiRequest(string $method, string $endpoint, array $data = [], bool $isProtected = true)
    {
        $url = self::getBackendUrl() . $endpoint;

        $request = Http::timeout(30)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);

        // Add Bearer token only if protected endpoint
        if ($isProtected) {
            $token = self::getToken();
            if ($token) {
                $request = $request->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                ]);
            }
        }

        return match (strtoupper($method)) {
            'GET' => $request->get($url, $data),
            'POST' => $request->post($url, $data),
            'PUT' => $request->put($url, $data),
            'DELETE' => $request->delete($url, $data),
            'PATCH' => $request->patch($url, $data),
            default => throw new \InvalidArgumentException("Unsupported HTTP method: {$method}"),
        };
    }

    /**
     * Logout user
     */
    public static function logout(): void
    {
        try {
            // Call backend logout endpoint
            self::apiRequest('POST', '/api/auth/logout');
        } catch (\Exception $e) {
            // Log error but continue with local logout
            Log::error('Logout API error: ' . $e->getMessage());
        }

        // Clear local session
        self::clearAuth();
    }

    /**
     * Verify token with backend
     */
    public static function verifyToken(): bool
    {
        try {
            $response = self::apiRequest('GET', '/api/auth/me');

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['data'])) {
                    // Update user data in session
                    session(['user' => $data['data']]);
                    return true;
                }
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
