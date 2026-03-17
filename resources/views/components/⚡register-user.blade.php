<?php

use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\User;

new class extends Component
{
    #[Validate('required|min:3|unique:users')]
    public ?string $name = '';

    #[Validate('required|email|unique:users')]
    public ?string $email = '';

    #[Validate('required|min:8|max:200')]
    public ?string $password = '';

    // Save the new user and log them in
    public function save()
    {
        $credentials = $this->validate();
        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);
        auth()->login($user);

        return $this->redirect('/');
    }
};
?>

<div style="border: 3px solid black; padding: 10px;">
    <h2>Register</h2>
    <form wire:submit="save">
        <label>
            Name
            <input type="text" name="name" placeholder="Name" wire:model="name" wire:model.live.blur="name">
            @error('name') <span style="color: red;">{{ $message }}</span> @enderror
        </label>
        <br />
        <label>
            Email
            <input type="email" name="email" placeholder="Email" wire:model="email" wire:model.live.blur="email">
            @error('email') <span style="color: red;">{{ $message }}</span> @enderror
        </label>
        <br />
        <label>
            Password
            <input type="password" name="password" placeholder="Password" wire:model="password" wire:model.live.blur="password">
            @error('password') <span style="color: red;">{{ $message }}</span> @enderror
        </label>
        <br />
        <button type="submit">
            <span wire:loading.remove>Register</span>
            <span wire:loading>Loading...</span>          
        </button>
    </form>
</div>