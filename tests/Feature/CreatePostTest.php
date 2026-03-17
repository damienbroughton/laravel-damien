<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a user to create a post', function () {
    // Create a user and a post
    $user = User::factory()->create();

    // Simulate the user being logged in and creating a post
    Livewire::actingAs($user)
        ->test('create-post')
        ->set('title', 'New Title')
        ->set('body', 'New Content')
        ->call('save')
        ->assertRedirect('/');

    // Assert the post was created in the database
    $this->assertDatabaseHas('posts', [
        'title' => 'New Title',
        'body' => 'New Content'
    ]);
});

it('blocks an anonymous user from creating a post', function () {
    // Simulate the user not being logged in and creating a post
    Livewire::test('create-post')
        ->set('title', 'New Title by Anonymous')
        ->set('body', 'New Content by Anonymous')
        ->call('save')
        ->assertStatus(403);

    // Assert the post was not created in the database
    $this->assertDatabaseMissing('posts', [
        'title' => 'New Title by Anonymous',
        'body' => 'New Content by Anonymous'
    ]);
});