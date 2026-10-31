<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class Index extends Component
{
    public string $search = '';

    public function deletePost(int $id): void
    {
        abort_unless(auth()->user()->can('delete posts'), 403);

        $post = Post::findOrFail($id);

        $image = $post->image;

        $post->delete();

        if ($image) {
            Storage::disk('public')->delete($image);
        }

        session()->flash('success', 'Artikel berhasil dihapus.');
    }

    public function render()
    {
        abort_unless(auth()->user()->can('view posts'), 403);

        return view('livewire.admin.posts.index', [
            'posts' => Post::with('user')
                ->when($this->search, function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->get(),
        ]);
    }
}
