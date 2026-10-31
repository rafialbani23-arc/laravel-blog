<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Livewire\Pages\EditPost;
use Livewire\Livewire;
use App\Livewire\Pages\MyPosts;

class PostAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(\Spatie\Permission\PermissionRegistrar::class)
            ->forgetCachedPermissions();

        Permission::findOrCreate('edit posts', 'web');
        Permission::findOrCreate('delete posts', 'web');

        $role = Role::findOrCreate('user', 'web');

        $role->givePermissionTo([
            'edit posts',
            'delete posts',
        ]);
    }

    public function test_user_cannot_edit_another_users_post(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $otherUser->assignRole('user');

        $post = Post::create([
            'user_id' => $owner->id,
            'title' => 'Artikel Rahasia',
            'slug' => 'artikel-rahasia',
            'content' => 'Konten artikel',
            'status' => 'published',
        ]);

        $this->actingAs($otherUser)
            ->get(route('posts.edit', $post))
            ->assertForbidden();
    }

    public function test_owner_can_edit_their_post(): void
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');

        $post = Post::create([
            'user_id' => $owner->id,
            'title' => 'Artikel Saya',
            'slug' => 'artikel-saya',
            'content' => 'Konten artikel',
            'status' => 'published',
        ]);

        $this->actingAs($owner)
            ->get(route('posts.edit', $post))
            ->assertOk();
    }
    public function test_user_cannot_update_another_users_post(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $otherUser->assignRole('user');

        $post = Post::create([
            'user_id' => $owner->id,
            'title' => 'Artikel Asli',
            'slug' => 'artikel-asli',
            'content' => 'Konten asli',
            'status' => 'published',
        ]);

        Livewire::actingAs($otherUser)
            ->test(EditPost::class, ['post' => $post])
            ->assertForbidden();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Artikel Asli',
            'content' => 'Konten asli',
        ]);
    }

    public function test_owner_can_update_their_post(): void
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');

        $post = Post::create([
            'user_id' => $owner->id,
            'title' => 'Artikel Lama',
            'slug' => 'artikel-lama',
            'content' => 'Konten lama',
            'status' => 'draft',
        ]);

        Livewire::actingAs($owner)
            ->test(EditPost::class, ['post' => $post])
            ->set('title', 'Artikel Baru')
            ->set('content', 'Konten baru')
            ->call('update')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Artikel Baru',
            'content' => 'Konten baru',
        ]);
    }

    public function test_user_cannot_delete_another_users_post(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $otherUser->assignRole('user');

        $post = Post::create([
            'user_id' => $owner->id,
            'title' => 'Artikel Orang Lain',
            'slug' => 'artikel-orang-lain',
            'content' => 'Konten artikel',
            'status' => 'published',
        ]);

        Livewire::actingAs($otherUser)
            ->test(MyPosts::class)
            ->call('delete', $post->id);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Artikel Orang Lain',
        ]);
    }

    public function test_owner_can_delete_their_post(): void
    {
        $owner = User::factory()->create();
        $owner->assignRole('user');

        $post = Post::create([
            'user_id' => $owner->id,
            'title' => 'Artikel Milik Saya',
            'slug' => 'artikel-milik-saya',
            'content' => 'Konten artikel',
            'status' => 'published',
        ]);

        Livewire::actingAs($owner)
            ->test(MyPosts::class)
            ->call('delete', $post->id);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
