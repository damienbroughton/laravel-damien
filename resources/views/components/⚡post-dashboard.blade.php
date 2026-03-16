<?php

use App\Models\Post;
use Livewire\Component;

new class extends Component
{
    public $posts;
    public int $totalCount;

    public function render()
    {
        $this->posts = Post::latest()->take(10)->get();
        $this->totalCount = Post::count();

        return view('components.⚡post-dashboard');
    }
};
?>

<div wire:poll.5s style="border: 3px solid black; padding: 10px;">
    <div style="display: flex; justify-content: space-between;">
        <h2>Top Posts</h2>
        <div style="font-weight: bold;">Total: {{ $totalCount }}</div>
    </div>

    <ul style="list-style: none; padding: 0;">
        @foreach($posts as $post)
            <li wire:key="{{ $post->id }}" style="padding: 10px; border-bottom: 1px solid #eee;">
                {{ $post->title }}
                <span style="font-size: 0.8rem; color: gray;">
                    - {{ $post->created_at->diffForHumans() }}
                </span>
            </li>
        @endforeach
    </ul>

    <div wire:loading style="color: blue; font-size: 0.8rem;">
        Checking for new posts...
    </div>
</div>