<?php

namespace Tests\Feature;

use App\Livewire\Pages\PostComments;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CommentAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function createPost(): Post
    {
        $author = User::factory()->create();

        return Post::create([
            'user_id' => $author->id,
            'title' => 'Artikel Testing',
            'slug' => 'artikel-testing',
            'content' => 'Konten artikel testing',
            'status' => 'published',
        ]);
    }

    public function test_guest_cannot_create_comment(): void
    {
        $post = $this->createPost();

        Livewire::test(PostComments::class, ['post' => $post])
            ->set('content', 'Komentar dari guest')
            ->call('save')
            ->assertForbidden();

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_logged_in_user_can_create_comment(): void
    {
        $post = $this->createPost();
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(PostComments::class, ['post' => $post])
            ->set('content', 'Komentar pertama')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'content' => 'Komentar pertama',
        ]);
    }

    public function test_user_cannot_delete_another_users_comment(): void
    {
        $post = $this->createPost();

        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $owner->id,
            'content' => 'Komentar milik owner',
        ]);

        Livewire::actingAs($otherUser)
            ->test(PostComments::class, ['post' => $post])
            ->call('deleteComment', $comment->id)
            ->assertForbidden();

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_owner_can_delete_their_comment(): void
    {
        $post = $this->createPost();
        $owner = User::factory()->create();

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $owner->id,
            'content' => 'Komentar saya',
        ]);

        Livewire::actingAs($owner)
            ->test(PostComments::class, ['post' => $post])
            ->call('deleteComment', $comment->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_admin_can_delete_another_users_comment(): void
    {
        $post = $this->createPost();

        $owner = User::factory()->create();
        $admin = User::factory()->create();

        Role::findOrCreate('admin', 'web');
        $admin->assignRole('admin');

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $owner->id,
            'content' => 'Komentar pengguna',
        ]);

        Livewire::actingAs($admin)
            ->test(PostComments::class, ['post' => $post])
            ->call('deleteComment', $comment->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_user_cannot_comment_on_draft_post(): void
    {
        $post = $this->createPost();
        $post->update(['status' => 'draft']);

        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(PostComments::class, ['post' => $post])
            ->assertNotFound();

        $this->assertDatabaseCount('comments', 0);
    }
}
