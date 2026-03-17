<?php

// This controller handles the creation, editing, and deletion of blog posts
// Currently, not in use as this functionality is being handled in the LiveWire component, 
// Except for the showEditScreen method, which is still used in the routes

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    // This method handles the creation of a new post
    public function createPost(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        // Blade already escapes output
        // $incomingFields['title'] = strip_tags($incomingFields['title']);
        // $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        Post::create($incomingFields);

        return redirect('/');
    }

    // This method handles the editing of an existing post
    public function editPost(Post $post, Request $request) {
        $this->authorize('update', $post);

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $post->update($incomingFields);

        return redirect('/');
    }

    // This method handles the deletion of a post
    public function deletePost(Post $post) {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect('/');
    }

    // This method shows the edit screen for a post
    public function showEditScreen(Post $post) {
        $this->authorize('update', $post);

        return view('edit-post', ['post' => $post]);
    }
}
