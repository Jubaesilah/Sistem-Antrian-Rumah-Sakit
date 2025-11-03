<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Helpers\AuthHelper;

class GoogleCallback extends Component
{
    public $token;
    public $user;
    public $error;
    public $errorMessage;
    public $email;
    public $userId;
    public $isProcessing = true;

    public function mount()
    {
        // Get parameters from URL
        $this->token = request()->query('token');
        $this->error = request()->query('error');
        $this->errorMessage = request()->query('message');
        $this->email = request()->query('email');
        $this->userId = request()->query('user_id');

        if (request()->query('user')) {
            $this->user = json_decode(request()->query('user'), true);
        }

        // Process the callback
        $this->processCallback();
    }

    public function processCallback()
    {
        if ($this->error) {
            // Handle errors
            $this->isProcessing = false;
            return;
        }

        if ($this->token) {
            // Store token and user using AuthHelper
            if ($this->user) {
                AuthHelper::setAuth($this->token, $this->user);
            } else {
                session(['auth_token' => $this->token]);
            }

            // Set processing to false to show success state
            $this->isProcessing = false;

            // Redirect to dashboard after 2 seconds
            $this->dispatch('login-success');
        } else {
            $this->error = 'invalid_response';
            $this->errorMessage = 'Token tidak ditemukan';
            $this->isProcessing = false;
        }
    }

    public function retryLogin()
    {
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.google-callback');
    }
}
