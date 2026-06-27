<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class Categories extends Component
{
    // Properties for Creating/Editing
    public $name = '';
    public $slug = '';
    public $description = '';

    public $editingCategoryId = null;
    public $editingName = '';
    public $editingSlug = '';
    public $editingDescription = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $this->editingCategoryId,
            'description' => 'nullable|string',
        ];
    }

    // Auto-generate slug during creation
    public function updatedName($value)
    {
        if (!$this->editingCategoryId) {
            $this->slug = Str::slug($value);
        }
    }

    // Auto-generate slug during inline editing
    public function updatedEditingName($value)
    {
        $this->editingSlug = Str::slug($value);
    }

    public function createCategory()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ]);

        $this->reset(['name', 'slug', 'description']);
        session()->flash('message', 'Category created successfully.');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->editingCategoryId = $id;
        $this->editingName = $category->name;
        $this->editingSlug = $category->slug;
        $this->editingDescription = $category->description;
    }

    public function cancelEdit()
    {
        $this->reset(['editingCategoryId', 'editingName', 'editingSlug', 'editingDescription']);
    }

    public function updateCategory()
    {
        $this->validate([
            'editingName' => 'required|string|max:255',
            'editingSlug' => 'required|string|max:255|unique:categories,slug,' . $this->editingCategoryId,
            'editingDescription' => 'nullable|string',
        ]);

        $category = Category::findOrFail($this->editingCategoryId);
        $category->update([
            'name' => $this->editingName,
            'slug' => $this->editingSlug,
            'description' => $this->editingDescription,
        ]);

        $this->cancelEdit();
        session()->flash('message', 'Category updated successfully.');
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function render()
    {
        $categories = Category::withCount('posts')->get();

        return view('livewire.admin.categories', compact('categories'))
            ->layout('components.layouts.admin')
            ->title('Manage Categories - Kernel Admin');
    }
}
