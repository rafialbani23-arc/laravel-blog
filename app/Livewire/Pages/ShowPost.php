<?php

namespace App\Livewire\Pages;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ShowPost extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        abort_unless($post->status === 'published', 404);

        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.pages.show-post');
    }
}
