<?php

use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Post;

new class extends Component
{
    public Post $post;
    
    #[Validate('required|min:3')]
    public ?string $title;

    #[Validate('required|min:10')]
    public ?string $body;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->title = $post->title;
        $this->body = $post->body;
    }

    // Save the updated post if authrized
    public function save() {
        $this->authorize('update', $this->post);

        $incomingFields = $this->validate();

        $this->post->title = strip_tags($incomingFields['title']);
        $this->post->body = strip_tags($incomingFields['body']);

        $this->post->update();
        return redirect('/');
    }
};
?>

<div style="border: 3px solid black; padding: 10px;">
    <h2>Update Post</h2>
    <form wire:submit="save">
        <label>
            Title
            <input type="text" wire:model="title" wire:model.live.blur="title">
            @error('title') <span style="color: red; display: block;">{{ $message }}</span> @enderror
        </label><br>
        <label>
            Body
            <textarea wire:model="body" wire:model.live.blur="body"></textarea><br>
            @error('body') <span style="color: red; display: block;">{{ $message }}</span> @enderror
        </label><br>
        @can('update', $post)
            <button type="submit">
                <span wire:loading.remove>Update Post</span>
                <span wire:loading>loading..</span>      
            </button>
        @else
            <p>You do not have permission to edit this.</p>
        @endcan
    </form>
</div>