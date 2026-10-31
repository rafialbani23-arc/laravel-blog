<?php

namespace App\Livewire\Pages;

use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class CreatePost extends Component
{
    use WithFileUploads;

    public $image;

    public $title = '';
    public $content = '';
    public $status = 'draft';

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $this->image
            ? $this->image->store('posts', 'public')
            : null;

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . Str::lower(Str::random(6)),
            'content' => $this->content,
            'image' => $imagePath,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Artikel berhasil dibuat!');

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.pages.create-post');
    }
}
