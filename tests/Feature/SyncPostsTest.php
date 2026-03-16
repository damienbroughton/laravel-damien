<?php

use App\Models\Post;
use App\Console\Commands\SyncArticles;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Interfaces\ExternalProviderServiceInterface;

uses(RefreshDatabase::class);

it('syncs posts from the external API successfully', function () {
    // Create a "Mock" version of the interface
    $mockService = Mockery::mock(ExternalProviderServiceInterface::class);
    $mockService->shouldReceive('fetchExternalPosts')->andReturn([
        ['id' => 999, 'title' => 'Mocked Title', 'body' => 'Mocked Body']
    ]);

    // Swap the real service for the mock in the container
    $this->app->instance(ExternalProviderServiceInterface::class, $mockService);

    // Run the sync-posts command
    $this->artisan('app:sync-posts')->assertExitCode(0);

    // Assert the data is in our database
    $this->assertDatabaseHas('posts', [
        'external_id' => 999,
        'title' => 'Mocked Title'
    ]);
});