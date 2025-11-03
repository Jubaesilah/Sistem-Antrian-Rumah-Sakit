<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Helpers\AuthHelper;

class Logout extends Component
{
    public function logout()
    {
        // Call logout helper
        AuthHelper::logout();
        
        // Redirect to login
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout');
    }
    
    public function render()
    {
        return view('livewire.auth.logout');
    }
}
