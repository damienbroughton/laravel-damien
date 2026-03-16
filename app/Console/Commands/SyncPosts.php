<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\User;
use App\Interfaces\ExternalProviderServiceInterface;


class SyncPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retreive and create or update posts from external provider';

    /**
     * Execute the console command.
     */
    public function handle(ExternalProviderServiceInterface $service) {
        // Find the system user or create them
        $externalUser = User::firstOrCreate(
            ['email' => 'system@external.com'],
            [
                'name' => 'External System',
                'password' => bcrypt(str()->random(32)),
            ]
        );

        // Fetch posts from the external API
        $data = $service->fetchExternalPosts();

        // Create or update posts in the database and assign them to the external user
        foreach ($data as $articleData) {
            Post::updateOrCreate(
                ['external_id' => $articleData['id']],
                [
                    'title' => $articleData['title'],
                    'body' => $articleData['body'],
                    'user_id' => $externalUser->id, 
                ]
            );
            $this->info("Synced article: " . $articleData['title']);
        }
    }
}
