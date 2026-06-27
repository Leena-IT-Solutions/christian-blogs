<?php

use App\Livewire\About;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\Tags;
use App\Livewire\Admin\Comments;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Login;
use App\Livewire\Admin\Messages;
use App\Livewire\Admin\Posts\Create as PostCreate;
use App\Livewire\Admin\Posts\Edit as PostEdit;
use App\Livewire\Admin\Posts\Index as PostIndex;
use App\Livewire\Admin\Settings;
use App\Livewire\Admin\SeoSettings;
use App\Livewire\Contact;
use App\Livewire\Home;
use App\Livewire\PostShow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// =========================================================================
// SEO: Sitemap & Robots
// =========================================================================
Route::get('/sitemap.xml', function () {
    $posts = \App\Models\Post::where('status', 'published')
        ->orderBy('published_at', 'desc')
        ->get(['slug', 'published_at', 'updated_at']);

    $content = view('sitemap', compact('posts'))->render();

    return response($content, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

// =========================================================================
// Public Blog Pages
// =========================================================================
Route::get('/', Home::class)->name('home');
Route::get('/about', About::class)->name('about');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/posts/{slug}', PostShow::class)->name('posts.show');

// =========================================================================
// Authentication Routes
// =========================================================================
Route::get('/login', Login::class)->name('login')->middleware('guest');

Route::post('/admin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('admin.logout')->middleware('auth');

// =========================================================================
// Admin Protected Panel
// =========================================================================
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
    Route::get('/categories', Categories::class)->name('admin.categories');
    Route::get('/tags', Tags::class)->name('admin.tags');
    Route::get('/posts', PostIndex::class)->name('admin.posts.index');
    Route::get('/posts/create', PostCreate::class)->name('admin.posts.create');
    Route::get('/posts/{id}/edit', PostEdit::class)->name('admin.posts.edit');
    Route::get('/comments', Comments::class)->name('admin.comments');
    Route::get('/messages', Messages::class)->name('admin.messages');
    Route::get('/settings', Settings::class)->name('admin.settings');
    Route::get('/seo', SeoSettings::class)->name('admin.seo');
});
