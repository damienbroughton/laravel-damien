<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the dashboard with posts and total count', function () {
    // Create a user and some posts
    $user = User::factory()->create();
    $posts = Post::factory()->count(3)->create(['user_id' => $user->id]);

    // 2Test the component
    Livewire::test('post-dashboard')
        ->assertSet('totalCount', 3) // Verify the count is correct
        ->assertSee(Post::first()->title) // Verify a post title is visible
        ->assertViewHas('posts', function ($posts) {
            return count($posts) === 3; // Verify 3 items are passed to the view
        });
});

it('updates the count automatically when new posts are added', function () {
    // Create a user and some posts
    $user = User::factory()->create();
    $posts = Post::factory()->create(['user_id' => $user->id]);

    $component = Livewire::test('post-dashboard')
        ->assertSet('totalCount', 1);

    // Simulate adding a new post
    Post::factory()->create(['title' => 'New Sync Post', 'user_id' => $user->id]);

    // Trigger a re-render
    $component->call('$refresh') 
        ->assertSet('totalCount', 2)
        ->assertSee('New Sync Post');
});