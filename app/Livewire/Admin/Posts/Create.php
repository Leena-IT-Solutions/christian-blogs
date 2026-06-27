<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    // Fields
    public $title = '';
    public $slug = '';
    public $category_id = '';
    public $excerpt = '';
    public $body = '';
    public $status = 'draft';
    public $selectedTags = []; // Array of tag IDs
    public $image;

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts,slug',
        'category_id' => 'required|exists:categories,id',
        'excerpt' => 'nullable|string|max:1000',
        'body' => 'required|string',
        'status' => 'required|in:draft,published',
        'selectedTags' => 'nullable|array',
        'selectedTags.*' => 'exists:tags,id',
        'image' => 'nullable|image|max:2048', // 2MB Max
    ];

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function savePost()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $filename = time() . '_' . Str::random(10) . '.' . $this->image->getClientOriginalExtension();
            $path = $this->image->storeAs('uploads', $filename, 'public');
            $imagePath = 'storage/' . $path;
        }

        $post = Post::create([
            'user_id' => Auth::id() ?? 1, // Fallback to 1 if no logged in user during seed/tests
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            'featured_image' => $imagePath,
            'status' => $this->status,
            'published_at' => $this->status === 'published' ? now() : null,
        ]);

        if (!empty($this->selectedTags)) {
            $post->tags()->sync($this->selectedTags);
        }

        session()->flash('message', 'Post created successfully.');
        return redirect()->to('/admin/posts');
    }

    public function render()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('livewire.admin.posts.create', compact('categories', 'tags'))
            ->layout('components.layouts.admin')
            ->title('Write Post - Kernel Admin');
    }
}
