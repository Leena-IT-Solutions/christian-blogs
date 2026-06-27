<div>
    <div class="admin-header">
        <div class="admin-title">
            <h1>Categories</h1>
            <p>Organize your articles into thematic sections</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="badge badge-success" style="padding: 12px 20px; font-size: 0.9rem; margin-bottom: 24px; display: block; border-radius: var(--radius-sm);">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid-1-2">
        
        <!-- Left Side: Create Form -->
        <div class="panel-card">
            <h2 class="panel-title" style="margin-bottom: 20px;">Add New Category</h2>
            
            <form wire:submit.prevent="createCategory">
                <div class="admin-form-group">
                    <label class="admin-label">Category Name</label>
                    <input type="text" wire:model.live="name" class="admin-control" placeholder="e.g. Daily Devotionals" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                
                <div class="admin-form-group">
                    <label class="admin-label">Slug (URL segment)</label>
                    <input type="text" wire:model.live="slug" class="admin-control" placeholder="e.g. daily-devotionals" required>
                    @error('slug') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                
                <div class="admin-form-group">
                    <label class="admin-label">Description (Optional)</label>
                    <textarea wire:model="description" class="admin-control" style="height: 100px; resize: vertical;" placeholder="Short summary of this category..."></textarea>
                    @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                
                <button type="submit" class="btn" style="width: 100%;">Create Category</button>
            </form>
        </div>

        <!-- Right Side: Categories Table -->
        <div class="panel-card">
            <h2 class="panel-title" style="margin-bottom: 20px;">All Categories</h2>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Articles</th>
                            <th style="width: 150px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                @if ($editingCategoryId === $category->id)
                                    <!-- Inline Edit Mode -->
                                    <td colspan="3">
                                        <div class="grid-inline-2" style="margin-bottom: 8px;">
                                            <div>
                                                <label class="admin-label" style="font-size: 0.75rem;">Name</label>
                                                <input type="text" wire:model.live="editingName" class="admin-control" style="padding: 6px 10px; font-size: 0.9rem;" required>
                                                @error('editingName') <span class="invalid-feedback" style="font-size: 0.75rem;">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label class="admin-label" style="font-size: 0.75rem;">Slug</label>
                                                <input type="text" wire:model.live="editingSlug" class="admin-control" style="padding: 6px 10px; font-size: 0.9rem;" required>
                                                @error('editingSlug') <span class="invalid-feedback" style="font-size: 0.75rem;">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div>
                                            <label class="admin-label" style="font-size: 0.75rem;">Description</label>
                                            <input type="text" wire:model="editingDescription" class="admin-control" style="padding: 6px 10px; font-size: 0.9rem;">
                                            @error('editingDescription') <span class="invalid-feedback" style="font-size: 0.75rem;">{{ $message }}</span> @enderror
                                        </div>
                                    </td>
                                    <td style="text-align: right; vertical-align: bottom;">
                                        <div class="btn-action-group" style="justify-content: flex-end; margin-top: 8px;">
                                            <button wire:click="updateCategory" class="btn-icon btn-icon-success" title="Save">Save</button>
                                            <button wire:click="cancelEdit" class="btn-icon" title="Cancel">Cancel</button>
                                        </div>
                                    </td>
                                @else
                                    <!-- Read Mode -->
                                    <td>
                                        <strong style="color: #ffffff; font-size: 1rem;">{{ $category->name }}</strong>
                                        @if ($category->description)
                                            <p style="color: var(--admin-text-muted); font-size: 0.85rem; margin: 4px 0 0;">{{ $category->description }}</p>
                                        @endif
                                    </td>
                                    <td><code style="color: var(--accent-color);">{{ $category->slug }}</code></td>
                                    <td>
                                        <span class="badge badge-success">{{ $category->posts_count }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-action-group" style="justify-content: flex-end;">
                                            <button wire:click="editCategory({{ $category->id }})" class="btn-icon" title="Edit Category">Edit</button>
                                            <button wire:click="deleteCategory({{ $category->id }})" 
                                                onclick="return confirm('Are you sure you want to delete this category? All related posts will be deleted.');" 
                                                class="btn-icon btn-icon-danger" title="Delete Category">Delete</button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--admin-text-muted); padding: 30px;">
                                    No categories found. Create one on the left.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
