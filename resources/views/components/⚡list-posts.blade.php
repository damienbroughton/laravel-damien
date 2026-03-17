<?php
use Livewire\Component;
use App\Models\Post;

new class extends Component {
    public $posts;

    public function mount() {
        $this->posts = Post::where('user_id', auth()->id())->get();
    }

    // Delete the post if authorized
    public function delete($postId) {
        $post = Post::findOrFail($postId);
        
        $this->authorize('delete', $post);

        $post->delete();
        return $this->redirect('/');
    }
}; 
?>

<div style="border: 3px solid black; padding: 10px;">
    <h2>My Posts</h2>
    @foreach($posts as $post)
    <div style="background-color: gray; padding: 10px; margin: 10px;"> 
        <h3>{{$post->title}} by <i>{{$post->user->name}}</i></h3>
        {{$post->body}}
        <p><a href="/edit-post/{{$post->id}}">Edit</a></p>
        @can('delete', $post)
            <form wire:submit="delete({{ $post->id }})">
                <button type="submit">Delete</button>
            </form>
        @else
            <p>You do not have permission to delete this post.</p>
        @endcan
    </div>
    @endforeach
</div>