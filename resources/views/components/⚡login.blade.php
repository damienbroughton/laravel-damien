<?php

use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\User;

new class extends Component
{
    #[Validate('required')]
    public string $loginName;

    #[Validate('required')]
    public string $loginPassword;

    public function login()
    {
        $credentials = $this->validate();
        if (auth()->attempt(['name' => $credentials['loginName'], 'password' => $credentials['loginPassword']])) {
            session()->regenerate();
            return $this->redirect('/');
        }
        $this->addError('loginName', 'Invalid credentials');
    }
};
?>

<div style="border: 3px solid black; padding: 10px;">
    <h2>Login</h2>
    <form wire:submit="login">
        <label>
            Name
            <input type="text" wire:model.blur="loginName" placeholder="Name">
            @error('loginName') <span style="color: red; display: block;">{{ $message }}</span> @enderror
        </label><br>

        <label>
            Password
            <input type="password" wire:model.blur="loginPassword" placeholder="Password">
            @error('loginPassword') <span style="color: red; display: block;">{{ $message }}</span> @enderror
        </label><br>
        <button type="submit">
            <span wire:loading.remove>Login</span>
            <span wire:loading>Logging in...</span>            
        </button>
    </form>
</div>