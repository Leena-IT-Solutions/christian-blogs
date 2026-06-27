<div>
    <div class="admin-header">
        <div class="admin-title">
            <h1>Tags</h1>
            <p>Manage tag identifiers for posts</p>
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
            <h2 class="panel-title" style="margin-bottom: 20px;">Add New Tag</h2>
            
            <form wire:submit.prevent="createTag">
                <div class="admin-form-group">
                    <label class="admin-label">Tag Name</label>
                    <input type="text" wire:model.live="name" class="admin-control" placeholder="e.g. Prayer" required>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                
                <div class="admin-form-group">
                    <label class="admin-label">Slug (URL segment)</label>
                    <input type="text" wire:model.live="slug" class="admin-control" placeholder="e.g. prayer" required>
                    @error('slug') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                
                <button type="submit" class="btn" style="width: 100%;">Create Tag</button>
            </form>
        </div>

        <!-- Right Side: Tags Table -->
        <div class="panel-card">
            <h2 class="panel-title" style="margin-bottom: 20px;">All Tags</h2>
            
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
                        @forelse ($tags as $tag)
                            <tr>
                                @if ($editingTagId === $tag->id)
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
                                    </td>
                                    <td style="text-align: right; vertical-align: bottom;">
                                        <div class="btn-action-group" style="justify-content: flex-end; margin-top: 8px;">
                                            <button wire:click="updateTag" class="btn-icon btn-icon-success" title="Save">Save</button>
                                            <button wire:click="cancelEdit" class="btn-icon" title="Cancel">Cancel</button>
                                        </div>
                                    </td>
                                @else
                                    <!-- Read Mode -->
                                    <td>
                                        <strong style="color: #ffffff; font-size: 1rem;">{{ $tag->name }}</strong>
                                    </td>
                                    <td><code style="color: var(--accent-color);">{{ $tag->slug }}</code></td>
                                    <td>
                                        <span class="badge badge-success">{{ $tag->posts_count }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-action-group" style="justify-content: flex-end;">
                                            <button wire:click="editTag({{ $tag->id }})" class="btn-icon" title="Edit Tag">Edit</button>
                                            <button wire:click="deleteTag({{ $tag->id }})" 
                                                onclick="return confirm('Are you sure you want to delete this tag?');" 
                                                class="btn-icon btn-icon-danger" title="Delete Tag">Delete</button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--admin-text-muted); padding: 30px;">
                                    No tags found. Create one on the left.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
