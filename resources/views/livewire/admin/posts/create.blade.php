<div>
    <div class="admin-header">
        <div class="admin-title">
            <h1>Write New Post</h1>
            <p>Draft or publish a new article to your blog</p>
        </div>
        <a href="/admin/posts" class="btn btn-secondary">Back to Posts</a>
    </div>

    <form wire:submit.prevent="savePost">
        <div class="grid-2-1">
            
            <!-- Left Panel: Content & Editor -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                
                <div class="panel-card">
                    <div class="admin-form-group">
                        <label class="admin-label">Title</label>
                        <input type="text" wire:model.live="title" class="admin-control" placeholder="Enter article title..." required>
                        @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-label">Slug (URL Segment)</label>
                        <input type="text" wire:model.live="slug" class="admin-control" placeholder="url-friendly-slug" required>
                        @error('slug') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-label">Excerpt (Brief summary for listing cards)</label>
                        <textarea wire:model="excerpt" class="admin-control" style="height: 80px; resize: vertical;" placeholder="Provide a short excerpt..."></textarea>
                        @error('excerpt') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Markdown Split Editor -->
                <div class="panel-card" style="padding: 24px;">
                    <label class="admin-label" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span>Body Content (Markdown)</span>
                        <span style="font-size: 0.8rem; color: var(--admin-text-muted); font-weight: normal;">HTML is auto-rendered in preview</span>
                    </label>

                    <div class="markdown-editor">
                        <!-- Editor Left Pane -->
                        <div class="editor-pane">
                            <textarea 
                                id="markdown-textarea"
                                wire:model.live.debounce.300ms="body" 
                                placeholder="Type your post body in Markdown format here... Use headers (#), lists (*), or quotes (>)."
                                oninput="updatePreview(this.value)"
                            ></textarea>
                        </div>
                        
                        <!-- Preview Right Pane -->
                        <div class="preview-pane">
                            <div id="markdown-preview" class="markdown-body">
                                <p style="color: var(--admin-text-muted); font-style: italic;">Your live article preview will render here...</p>
                            </div>
                        </div>
                    </div>
                    @error('body') <span class="invalid-feedback" style="margin-top: 12px; display: block;">{{ $message }}</span> @enderror
                </div>

            </div>

            <!-- Right Panel: Metadata & Uploads -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                
                <!-- Publish Panel -->
                <div class="panel-card">
                    <h3 class="panel-title" style="font-size: 1.15rem; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Publish Settings</h3>
                    
                    <div class="admin-form-group">
                        <label class="admin-label">Status</label>
                        <select wire:model="status" class="admin-control">
                            <option value="draft">Draft</option>
                            <option value="published">Publish Immediately</option>
                        </select>
                        @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn" style="width: 100%; margin-top: 8px;">Save Post</button>
                </div>

                <!-- Category Selector -->
                <div class="panel-card">
                    <h3 class="panel-title" style="font-size: 1.15rem; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Category</h3>
                    
                    <div class="admin-form-group">
                        <select wire:model="category_id" class="admin-control" required>
                            <option value="">Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Tag Manager -->
                <div class="panel-card">
                    <h3 class="panel-title" style="font-size: 1.15rem; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Tags</h3>
                    
                    <div class="tag-manager-list">
                        @foreach ($tags as $tag)
                            <label class="tag-checkbox-label {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}">
                                <input type="checkbox" value="{{ $tag->id }}" wire:model.live="selectedTags">
                                {{ $tag->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('selectedTags') <span class="invalid-feedback" style="margin-top: 12px; display: block;">{{ $message }}</span> @enderror
                </div>

                <!-- Featured Image Upload -->
                <div class="panel-card">
                    <h3 class="panel-title" style="font-size: 1.15rem; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Featured Image</h3>
                    
                    <div class="image-upload-wrapper" onclick="document.getElementById('image-upload-input').click()">
                        <input type="file" id="image-upload-input" wire:model="image" style="display: none;" accept="image/*">
                        
                        @if ($image)
                            <div style="font-size: 0.85rem; color: #4ade80;">Image Selected:</div>
                            <img src="{{ $image->temporaryUrl() }}" class="image-preview" alt="Preview">
                        @else
                            <svg style="width: 40px; height: 40px; margin: 0 auto 10px; color: var(--admin-text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p style="font-size: 0.85rem; color: var(--admin-text-muted);">Click to upload featured image (PNG, JPG, max 2MB)</p>
                        @endif

                        <div wire:loading wire:target="image" style="font-size: 0.85rem; color: var(--accent-color); margin-top: 10px;">Uploading to server temporary path...</div>
                        @error('image') <span class="invalid-feedback" style="margin-top: 10px; display: block;">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>

        </div>
    </form>

    <!-- Client-side Markdown Parser CDN -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        function updatePreview(val) {
            const previewEl = document.getElementById('markdown-preview');
            if (val.trim() === '') {
                previewEl.innerHTML = '<p style="color: var(--admin-text-muted); font-style: italic;">Your live article preview will render here...</p>';
            } else {
                try {
                    previewEl.innerHTML = marked.parse(val);
                } catch (e) {
                    console.error("Marked parsing failed: ", e);
                }
            }
        }

        // Run on load in case there is pre-existing body content
        document.addEventListener('livewire:initialized', () => {
            const txt = document.getElementById('markdown-textarea');
            if (txt && txt.value) {
                updatePreview(txt.value);
            }
        });
    </script>
</div>
