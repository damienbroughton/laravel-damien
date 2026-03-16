<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a user to edit a post', function () {
    // Create a user and a post
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    // Simulate the user being logged in
    Livewire::actingAs($user)
        ->test('edit-post', ['post' => $post])
        ->set('title', 'Updated Title')
        ->set('body', 'Updated Content')
        ->call('save')
        ->assertRedirect('/');

    // Assert the post was updated in the database
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Updated Title',
        'body' => 'Updated Content'
    ]);
});

it('blocks a user from editing another users post', function () {
    // Create two users and a post
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user1->id]);

    // Simulate the second user being logged in
    Livewire::actingAs($user2)
        ->test('edit-post', ['post' => $post])
        ->set('title', 'Updated Title by User 2')
        ->set('body', 'Updated Content by User 2')
        ->call('save')
        ->assertRedirect('/');

    // Assert the post was *not* updated in the database
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => $post->title,
        'body' => $post->body
    ]);
    Livewire::actingAs($user1)
        ->test('edit-post', ['post' => $post])
        ->set('title', 'Updated Title by User 1')
        ->set('body', 'Updated Content by User 1')
        ->call('save')
        ->assertRedirect('/');

    // Assert the post was updated in the database
    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Updated Title by User 1',
        'body' => 'Updated Content by User 1'
    ]);
});