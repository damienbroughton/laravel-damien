<?php

use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Post;

new class extends Component
{
    #[Validate('required|min:3')]
    public ?string $title = '';

    #[Validate('required|min:10')]
    public ?string $body = '';

    // Save the new post if authorized
    public function save()
    {
        $this->authorize('create', Post::class);

        $newPost = $this->validate();
        $newPost['title'] = strip_tags($newPost['title']);
        $newPost['body'] = strip_tags($newPost['body']);
        $newPost['user_id'] = auth()->id();
        Post::create($newPost);
        return $this->redirect('/');
    }
};
?>

<div style="border: 3px solid black; padding: 10px;">
    <h2>Create Post</h2>
    <form wire:submit="save">
        <label>
            Title
            <input type="text" wire:model="title" wire:model.live.blur="title" placeholder="Title">
            @error('title') <span style="color: red; display: block;">{{ $message }}</span> @enderror
        </label><br>
        <label>
            Body
            <textarea wire:model="body" wire:model.live.blur="body" placeholder="Body"></textarea><br>
            @error('body') <span style="color: red; display: block;">{{ $message }}</span> @enderror
        </label><br>
        <button type="submit">
            <span wire:loading.remove>Create Post</span>
            <span wire:loading>loading..</span>      
        </button>
    </form>
</div>