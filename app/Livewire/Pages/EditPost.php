<?php

namespace App\Livewire\Pages;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class EditPost extends Component
{
    use WithFileUploads;

    public $image;

    public Post $post;

    public string $title = '';
    public string $content = '';
    public string $status = 'draft';

    private function authorizeEdit(Post $post): void
    {
        abort_unless(
            auth()->check()
            && auth()->user()->can('edit posts')
            && (
                auth()->id() === $post->user_id
                || auth()->user()->hasRole('admin')
            ),
            403
        );
    }

    public function mount(Post $post): void
    {
        $this->authorizeEdit($post);

        $this->post = $post;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->status = $post->status;
    }

    public function update()
    {
        $post = Post::findOrFail($this->post->id);

        // Periksa ulang akses setiap kali artikel disimpan.
        $this->authorizeEdit($post);

        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
        ];

        $oldImagePath = null;
        $newImagePath = null;

        if ($this->image) {
            $newImagePath = $this->image->store('posts', 'public');

            $oldImagePath = $post->image;
            $data['image'] = $newImagePath;
        }

        try {
            $post->update($data);
        } catch (\Throwable $e) {
            // Bersihkan gambar baru jika update database gagal.
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            throw $e;
        }

        // Hapus gambar lama setelah update database berhasil.
        if ($oldImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()->route('posts.mine');
    }

    public function render()
    {
        return view('livewire.pages.edit-post');
    }
}
