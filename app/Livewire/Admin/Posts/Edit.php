<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $postId;
    public $title = '';
    public $slug = '';
    public $category_id = '';
    public $excerpt = '';
    public $body = '';
    public $status = '';
    public $selectedTags = [];
    public $image; // new image upload
    public $existingImage; // path to existing featured image

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $this->postId,
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string|max:1000',
            'body' => 'required|string',
            'status' => 'required|in:draft,published',
            'selectedTags' => 'nullable|array',
            'selectedTags.*' => 'exists:tags,id',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // 5MB Max
        ];
    }

    public function mount($id)
    {
        $post = Post::findOrFail($id);
        $this->postId = $post->id;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->category_id = $post->category_id;
        $this->excerpt = $post->excerpt;
        $this->body = $post->body;
        $this->status = $post->status;
        $this->existingImage = $post->featured_image;
        $this->selectedTags = $post->tags->pluck('id')->toArray();
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatePost()
    {
        $this->validate();

        $post = Post::findOrFail($this->postId);
        $imagePath = $this->existingImage;

        if ($this->image) {
            // Delete old image if exists
            if ($this->existingImage) {
                $oldImagePath = public_path(str_replace('storage/', '', $this->existingImage));
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
                $oldImagePathSym = public_path($this->existingImage);
                if ($oldImagePathSym !== $oldImagePath && file_exists($oldImagePathSym)) {
                    @unlink($oldImagePathSym);
                }
            }

            $filename = time() . '_' . Str::random(10) . '.' . $this->image->getClientOriginalExtension();
            if (!file_exists(public_path('uploads'))) {
                @mkdir(public_path('uploads'), 0755, true);
            }
            $this->image->move(public_path('uploads'), $filename);
            $imagePath = 'uploads/' . $filename;
        }

        // Handle published_at logic
        $publishedAt = $post->published_at;
        if ($this->status === 'published' && $post->status !== 'published') {
            $publishedAt = now();
        } elseif ($this->status === 'draft') {
            $publishedAt = null;
        }

        $post->update([
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            'featured_image' => $imagePath,
            'status' => $this->status,
            'published_at' => $publishedAt,
        ]);

        $post->tags()->sync($this->selectedTags);

        session()->flash('message', 'Post updated successfully.');
        return redirect()->to('/admin/posts');
    }

    public function render()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('livewire.admin.posts.edit', compact('categories', 'tags'))
            ->layout('components.layouts.admin')
            ->title('Edit Post - Admin');
    }
}
