<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        
        // Remove featured image if it exists in public storage
        if ($post->featured_image) {
            $imagePath = public_path($post->featured_image);
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        $post->delete();
        session()->flash('message', 'Post deleted successfully.');
    }

    public function render()
    {
        $posts = Post::with(['category', 'user'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('body', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.posts.index', compact('posts'))
            ->layout('components.layouts.admin')
            ->title('Manage Posts - Admin');
    }
}
