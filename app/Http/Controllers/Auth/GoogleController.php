<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    /**
     * Redirect ke Google OAuth di backend
     */
    public function redirect()
    {
        // Redirect ke backend API untuk Google OAuth
        $backendUrl = env('BACKEND_API_URL', 'http://localhost:8000');
        return redirect($backendUrl . '/api/auth/google');
    }
    
    /**
     * Handle callback dari Google (tidak digunakan, callback langsung dari backend)
     */
    public function callback()
    {
        // Callback akan ditangani oleh backend dan redirect ke /auth/callback
        return redirect()->route('auth.callback');
    }
}
