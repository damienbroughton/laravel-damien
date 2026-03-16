<?php

use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a user to register', function () {
    // Test User Data
    $fakeName = fake()->name();
    $fakeEmail = fake()->unique()->safeEmail();
    // Simulate the user filling out the registration form
    Livewire::test('register-user')
        ->set('name', $fakeName)
        ->set('email', $fakeEmail)
        ->set('password', 'password')
        ->call('save')
        ->assertRedirect('/');

    // Assert the user was created in the database
    $this->assertDatabaseHas('users', [
        'name' => $fakeName,
        'email' => $fakeEmail
    ]);
});

