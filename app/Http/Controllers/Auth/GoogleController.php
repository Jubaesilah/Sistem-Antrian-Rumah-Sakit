<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    /**
     * Redirect ke Google OAuth
     */
    public function redirect()
    {
        // Implementasi nanti menggunakan Laravel Socialite
        // return Socialite::driver('google')->redirect();
        
        // Untuk saat ini, kita hanya buat dummy redirect
        return redirect()->route('login');
    }
    
    /**
     * Handle callback dari Google
     */
    public function callback()
    {
        // Implementasi nanti menggunakan Laravel Socialite
        // $googleUser = Socialite::driver('google')->user();
        
        // Untuk saat ini, kita hanya buat dummy redirect
        return redirect()->route('display.antrian');
    }
}
