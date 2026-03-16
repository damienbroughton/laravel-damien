<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows a user to view the list of posts', function () {
    // Create a user and some posts
    $user = User::factory()->create();
    $posts = Post::factory()->count(3)->create(['user_id' => $user->id]);

    // Simulate the user being logged in and viewing the list of posts
    Livewire::actingAs($user)
        ->test('list-posts')
        ->assertSee($posts[0]->title)
        ->assertSee($posts[1]->title)
        ->assertSee($posts[2]->title);
});

it('user can delete own post', function () {
    // Create a user and some posts
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    // Simulate the user deleting the post
    Livewire::actingAs($user)
        ->test('list-posts')
        ->call('delete', $post->id)
        ->assertRedirect('/');

    // 3. Assert: Verify it's gone from the database
    $this->assertDatabaseMissing('posts', [
        'id' => $post->id
    ]);
});

it('user cannot delete someone elses post', function () {
    // Createa 2 users and a posts
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $otherUser->id]);

    // Try to delete the other users post
    Livewire::actingAs($user)
        ->test('list-posts')
        ->call('delete', $post->id)
        ->assertStatus(403); // Fails with Forbidden

    // Verify the post still exists in the database
    $this->assertDatabaseHas('posts', [
        'id' => $post->id
    ]);
});