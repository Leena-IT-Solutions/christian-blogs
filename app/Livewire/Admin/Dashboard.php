<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'posts_total' => Post::count(),
            'posts_published' => Post::where('status', 'published')->count(),
            'posts_draft' => Post::where('status', 'draft')->count(),
            'categories' => Category::count(),
            'tags' => Tag::count(),
            'comments_pending' => Comment::where('is_approved', false)->count(),
            'messages_unread' => Message::count(), // Message count
        ];

        return view('livewire.admin.dashboard', compact('stats'))
            ->layout('components.layouts.admin')
            ->title('Dashboard - Kernel Admin');
    }
}
