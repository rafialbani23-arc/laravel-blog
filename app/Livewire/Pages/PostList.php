<?php

namespace App\Livewire\Pages;

use App\Models\Post;
use Livewire\Component;

class PostList extends Component
{
    public function render()
    {
        return view('livewire.pages.post-list', [
            'posts' => Post::where('status', 'published')
                ->latest()
                ->get(),
        ]);
    }
}
