<?php

use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a user to login', function () {
    // Test User Data
    $fakeName = fake()->name();
    $fakeEmail = fake()->unique()->safeEmail();
    // Create a user
    $user = User::factory()->create([
        'name' => $fakeName,
        'email' => $fakeEmail,
        'password' => bcrypt('password'),
    ]);

    // Simulate the user filling out the login form
    Livewire::test('login')
        ->set('loginName', $fakeName)
        ->set('loginPassword', 'password')
        ->call('login')
        ->assertRedirect('/');
});

it('blocks a user from logging in with invalid credentials', function () {
    // Test User Data
    $fakeName = fake()->name();

    // Simulate the user filling out the login form
    Livewire::test('login')
        ->set('loginName', $fakeName)
        ->set('loginPassword', 'password')
        ->call('login')
        ->assertHasErrors(['loginName']);
});