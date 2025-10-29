<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Login extends Component
{
    public $isLoading = false;
    
    public function loginWithGoogle()
    {
        $this->isLoading = true;
        
        // Redirect ke Google OAuth
        // Untuk demo, kita tambahkan delay 1 detik untuk simulasi loading
        // Dalam implementasi sebenarnya, tidak perlu delay
        
        $this->dispatch('redirect-to-google');
    }
    
    public function render()
    {
        return view('livewire.auth.login');
    }
}
