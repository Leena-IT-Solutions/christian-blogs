<div>
    <div class="admin-header">
        <div class="admin-title">
            <h1>Site Settings</h1>
            <p>Configure site branding, social networks, and biographical content</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="badge badge-success" style="padding: 12px 20px; font-size: 0.9rem; margin-bottom: 24px; display: block; border-radius: var(--radius-sm);">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="saveSettings">
        <div class="grid-2-1">
            
            <!-- Left Side: Site Identity & About Text -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                
                <div class="panel-card">
                    <h2 class="panel-title" style="margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Identity & Title</h2>
                    
                    <div class="admin-form-group">
                        <label class="admin-label">Site Title</label>
                        <input type="text" wire:model="site_title" class="admin-control" placeholder="e.g. Be Rooted in Christ" required>
                        @error('site_title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-form-group" style="margin-top: 20px;">
                        <label class="admin-label">Site Tagline / Subtitle</label>
                        <input type="text" wire:model="site_subtitle" class="admin-control" placeholder="e.g. Planted to Prevail & Produce" required>
                        @error('site_subtitle') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-form-group" style="margin-top: 20px;">
                        <label class="admin-label">Site Logo (Upload new logo or leave blank to keep current)</label>
                        <div style="display: flex; align-items: center; gap: 20px; margin-top: 10px; flex-wrap: wrap;">
                            @if ($site_logo)
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span style="font-size: 0.75rem; color: #4ade80;">Previewing Uploaded:</span>
                                    <img src="{{ $site_logo->temporaryUrl() }}" style="max-height: 50px; width: auto; object-fit: contain; border: 1px solid var(--admin-border); padding: 4px; border-radius: var(--radius-sm); background-color: #000;" alt="Logo Preview">
                                </div>
                            @elseif ($existing_site_logo)
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span style="font-size: 0.75rem; color: var(--accent-color);">Current Logo:</span>
                                    <img src="{{ asset($existing_site_logo) }}" style="max-height: 50px; width: auto; object-fit: contain; border: 1px solid var(--admin-border); padding: 4px; border-radius: var(--radius-sm); background-color: #000;" alt="Current Logo">
                                </div>
                            @else
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span style="font-size: 0.75rem; color: var(--admin-text-muted);">Default Logo:</span>
                                    <img src="{{ asset('images/logo.png') }}" style="max-height: 50px; width: auto; object-fit: contain; border: 1px solid var(--admin-border); padding: 4px; border-radius: var(--radius-sm); opacity: 0.7; background-color: #000;" alt="Default Logo">
                                </div>
                            @endif
                            
                            <div style="flex-grow: 1; min-width: 200px;">
                                <input type="file" wire:model="site_logo" accept="image/*" class="admin-control" style="padding: 8px;">
                                <div wire:loading wire:target="site_logo" style="font-size: 0.85rem; color: var(--accent-color); margin-top: 4px;">Uploading...</div>
                            </div>
                        </div>
                        <small style="color: var(--admin-text-muted); display: block; margin-top: 8px;">Recommended dimensions: 150x50 pixels. Transparent PNG or SVG is preferred for best visual rendering.</small>
                        @error('site_logo') <span class="invalid-feedback" style="display: block; margin-top: 8px;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="panel-card">
                    <h2 class="panel-title" style="margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">About Page Biography</h2>
                    
                    <div class="admin-form-group">
                        <label class="admin-label">Biographical Text (Markdown supported)</label>
                        <textarea wire:model="about_text" class="admin-control" style="height: 300px; resize: vertical;" placeholder="Write your about page content..." required></textarea>
                        @error('about_text') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>

            <!-- Right Side: Social Media & Profile Photo -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                
                <div class="panel-card">
                    <h3 class="panel-title" style="font-size: 1.15rem; margin-bottom: 16px; text-transform: uppercase; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Profile Photo</h3>
                    
                    <div class="image-upload-wrapper" onclick="document.getElementById('profile-image-input').click()">
                        <input type="file" id="profile-image-input" wire:model="about_image" style="display: none;" accept="image/*">
                        
                        @if ($about_image)
                            <div style="font-size: 0.85rem; color: #4ade80;">New Image Selected:</div>
                            <img src="{{ $about_image->temporaryUrl() }}" class="image-preview" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover;" alt="Preview">
                        @elseif ($existing_about_image)
                            <div style="font-size: 0.85rem; color: var(--accent-color);">Existing Photo:</div>
                            <img src="{{ asset($existing_about_image) }}" class="image-preview" style="border-radius: 50%; width: 120px; height: 120px; object-fit: cover;" alt="Profile">
                            <p style="font-size: 0.75rem; color: var(--admin-text-muted); margin-top: 8px;">Click to replace photo</p>
                        @else
                            <svg style="width: 40px; height: 40px; margin: 0 auto 10px; color: var(--admin-text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p style="font-size: 0.85rem; color: var(--admin-text-muted);">Click to upload profile photo</p>
                        @endif

                        <div wire:loading wire:target="about_image" style="font-size: 0.85rem; color: var(--accent-color); margin-top: 10px;">Uploading...</div>
                        @error('about_image') <span class="invalid-feedback" style="margin-top: 10px; display: block;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="panel-card">
                    <h3 class="panel-title" style="font-size: 1.15rem; margin-bottom: 16px; text-transform: uppercase; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Social Media</h3>
                    
                    <div class="admin-form-group">
                        <label class="admin-label">Facebook URL</label>
                        <input type="url" wire:model="facebook_link" class="admin-control" placeholder="https://facebook.com/username">
                        @error('facebook_link') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-label">Instagram URL</label>
                        <input type="url" wire:model="instagram_link" class="admin-control" placeholder="https://instagram.com/username">
                        @error('instagram_link') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="submit" class="btn" style="width: 100%;">Save All Settings</button>

            </div>
        </div>
    </form>
</div>
