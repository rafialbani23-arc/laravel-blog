<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\CreatePost;
use App\Livewire\Pages\EditPost;
use App\Livewire\Pages\MyPosts;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Users\Index as UsersIndex;
use App\Livewire\Admin\Posts\Index as AdminPostsIndex;
use App\Livewire\Pages\ShowPost;

Route::get('/', Home::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/posts/create', CreatePost::class)
        ->name('posts.create');

    Route::get('/my-posts', MyPosts::class)
        ->name('posts.mine');

    Route::get('/posts/{post}/edit', EditPost::class)
        ->name('posts.edit');
});

Route::middleware(['auth', 'can:view users'])->group(function () {

    Route::get('/admin/dashboard', Dashboard::class)
        ->name('admin.dashboard');

    Route::get('/admin/users', UsersIndex::class)
        ->name('admin.users');

    Route::get('/admin/posts', AdminPostsIndex::class)
        ->name('admin.posts');

});

Route::get('/articles/{post:slug}', ShowPost::class)
    ->name('posts.show');
