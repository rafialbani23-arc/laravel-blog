<?php

namespace App\Livewire\Pages;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class MyPosts extends Component
{
    public function delete($id)
    {
        abort_unless(
            auth()->check() && auth()->user()->can('delete posts'),
            403
        );

        $post = \App\Models\Post::query()
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $imagePath = $post->image;

        $post->delete();

        if ($imagePath) {
            \Illuminate\Support\Facades\Storage::disk('public')
                ->delete($imagePath);
        }
    }

    public function render()
    {
        return view('livewire.pages.my-posts', [
            'posts' => Post::where('user_id', auth()->id())
                ->latest()
                ->get(),
        ]);
    }
}
