<?php

namespace App\Livewire\Pages;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;

class PostComments extends Component
{
    public Post $post;

    public string $content = '';

    public function mount(Post $post): void
    {
        abort_unless($post->status === 'published', 404);

        $this->post = $post;
    }

    public function save(): void
    {
        abort_unless(auth()->check(), 403);

        abort_unless(
            $this->post->fresh()?->status === 'published',
            404
        );

        $this->validate([
            'content' => 'required|string|min:2|max:1000',
        ]);

        Comment::create([
            'post_id' => $this->post->id,
            'user_id' => auth()->id(),
            'content' => $this->content,
        ]);

        $this->reset('content');
    }

    public function deleteComment(int $id): void
    {
        abort_unless(auth()->check(), 403);

        $comment = Comment::where('post_id', $this->post->id)
            ->findOrFail($id);

        abort_unless(
            $comment->user_id === auth()->id()
            || auth()->user()->hasRole('admin'),
            403
        );

        $comment->delete();
    }

    public function render()
    {
        return view('livewire.pages.post-comments', [
            'comments' => Comment::with('user')
                ->where('post_id', $this->post->id)
                ->oldest()
                ->get(),
        ]);
    }
}
