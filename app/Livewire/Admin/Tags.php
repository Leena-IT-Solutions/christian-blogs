<?php

namespace App\Livewire\Admin;

use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Component;

class Tags extends Component
{
    // Properties for Creating/Editing
    public $name = '';
    public $slug = '';

    public $editingTagId = null;
    public $editingName = '';
    public $editingSlug = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tags,slug,' . $this->editingTagId,
        ];
    }

    // Auto-generate slug during creation
    public function updatedName($value)
    {
        if (!$this->editingTagId) {
            $this->slug = Str::slug($value);
        }
    }

    // Auto-generate slug during inline editing
    public function updatedEditingName($value)
    {
        $this->editingSlug = Str::slug($value);
    }

    public function createTag()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tags,slug',
        ]);

        Tag::create([
            'name' => $this->name,
            'slug' => $this->slug,
        ]);

        $this->reset(['name', 'slug']);
        session()->flash('message', 'Tag created successfully.');
    }

    public function editTag($id)
    {
        $tag = Tag::findOrFail($id);
        $this->editingTagId = $id;
        $this->editingName = $tag->name;
        $this->editingSlug = $tag->slug;
    }

    public function cancelEdit()
    {
        $this->reset(['editingTagId', 'editingName', 'editingSlug']);
    }

    public function updateTag()
    {
        $this->validate([
            'editingName' => 'required|string|max:255',
            'editingSlug' => 'required|string|max:255|unique:tags,slug,' . $this->editingTagId,
        ]);

        $tag = Tag::findOrFail($this->editingTagId);
        $tag->update([
            'name' => $this->editingName,
            'slug' => $this->editingSlug,
        ]);

        $this->cancelEdit();
        session()->flash('message', 'Tag updated successfully.');
    }

    public function deleteTag($id)
    {
        Tag::findOrFail($id)->delete();
        session()->flash('message', 'Tag deleted successfully.');
    }

    public function render()
    {
        $tags = Tag::withCount('posts')->get();

        return view('livewire.admin.tags', compact('tags'))
            ->layout('components.layouts.admin')
            ->title('Manage Tags - Admin');
    }
}
