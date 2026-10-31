<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        abort_unless(auth()->user()?->can('view users'), 403);

        return view('livewire.admin.dashboard', [
            'totalPosts' => Post::count(),
            'publishedPosts' => Post::where('status', 'published')->count(),
            'draftPosts' => Post::where('status', 'draft')->count(),
            'totalUsers' => User::count(),
            'totalComments' => Comment::count(),
            'latestPosts' => Post::with('user')->latest()->take(5)->get(),
        ]);
    }
}
