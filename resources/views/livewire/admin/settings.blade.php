<div>
    <div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap;">
        <div class="admin-title">
            <h1>Site Settings</h1>
            <p>Configure site branding, social networks, and biographical content</p>
        </div>
        <button type="submit" form="settings-form" class="btn" style="padding: 10px 24px;">Save Settings</button>
    </div>

    @if (session()->has('message'))
        <div class="badge badge-success" style="padding: 12px 20px; font-size: 0.9rem; margin-bottom: 24px; display: block; border-radius: var(--radius-sm);">
            {{ session('message') }}
        </div>
    @endif

    <form id="settings-form" wire:submit.prevent="saveSettings">
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

                    <!-- Favicon Section -->
                    <div class="admin-form-group" style="margin-top: 24px; border-top: 1px dashed var(--admin-border); padding-top: 20px;">
                        <label class="admin-label" style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 600;">
                            <input type="checkbox" wire:model.live="use_logo_as_favicon" style="width: 18px; height: 18px; cursor: pointer; accent-color: var(--accent-color);">
                            <span>Use Site Logo as Favicon</span>
                        </label>
                        <small style="color: var(--admin-text-muted); display: block; margin-top: 4px; margin-left: 28px;">If checked, your website logo will automatically be scaled down and used as the favicon.</small>
                    </div>

                    @if (!$use_logo_as_favicon)
                        <div class="admin-form-group" style="margin-top: 20px; margin-left: 28px;">
                            <label class="admin-label">Custom Site Favicon (Upload new favicon or leave blank to keep current)</label>
                            <div style="display: flex; align-items: center; gap: 20px; margin-top: 10px; flex-wrap: wrap;">
                                @if ($site_favicon)
                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                        <span style="font-size: 0.75rem; color: #4ade80;">Previewing:</span>
                                        <img src="{{ $site_favicon->temporaryUrl() }}" style="width: 32px; height: 32px; object-fit: contain; border: 1px solid var(--admin-border); padding: 2px; border-radius: var(--radius-sm); background-color: #000;" alt="Favicon Preview">
                                    </div>
                                @elseif ($existing_site_favicon)
                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                        <span style="font-size: 0.75rem; color: var(--accent-color);">Current Favicon:</span>
                                        <img src="{{ asset($existing_site_favicon) }}" style="width: 32px; height: 32px; object-fit: contain; border: 1px solid var(--admin-border); padding: 2px; border-radius: var(--radius-sm); background-color: #000;" alt="Current Favicon">
                                    </div>
                                @else
                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                        <span style="font-size: 0.75rem; color: var(--admin-text-muted);">Default Favicon:</span>
                                        <img src="{{ asset('favicon.png') }}" style="width: 32px; height: 32px; object-fit: contain; border: 1px solid var(--admin-border); padding: 2px; border-radius: var(--radius-sm); background-color: #000;" alt="Default Favicon">
                                    </div>
                                @endif
                                
                                <div style="flex-grow: 1; min-width: 200px;">
                                    <input type="file" wire:model="site_favicon" accept="image/*" class="admin-control" style="padding: 8px;">
                                    <div wire:loading wire:target="site_favicon" style="font-size: 0.85rem; color: var(--accent-color); margin-top: 4px;">Uploading...</div>
                                </div>
                            </div>
                            <small style="color: var(--admin-text-muted); display: block; margin-top: 8px;">Recommended dimensions: 32x32 pixels. PNG or ICO format preferred.</small>
                            @error('site_favicon') <span class="invalid-feedback" style="display: block; margin-top: 8px;">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>

                <!-- Homepage Hero Section Panel Card -->
                <div class="panel-card">
                    <h2 class="panel-title" style="margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Homepage Hero Section</h2>
                    
                    <div class="admin-form-group">
                        <label class="admin-label">Hero Title</label>
                        <input type="text" wire:model="hero_title" class="admin-control" placeholder="e.g. Planted to Prevail" required>
                        @error('hero_title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-form-group" style="margin-top: 20px;">
                        <label class="admin-label">Hero Subtitle</label>
                        <textarea wire:model="hero_subtitle" class="admin-control" style="height: 80px; resize: vertical;" placeholder="e.g. Sowing seeds of Truth, nurturing roots of faith..." required></textarea>
                        @error('hero_subtitle') <span class="invalid-feedback">{{ $message }}</span> @enderror
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

                <div class="panel-card">
                    <h2 class="panel-title" style="margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Footer Verse / Quote</h2>
                    
                    <div class="admin-form-group">
                        <label class="admin-label">Verse / Quote Text</label>
                        <textarea wire:model="footer_quote_text" class="admin-control" style="height: 80px; resize: vertical;" placeholder='e.g. "As ye have therefore received Christ Jesus the Lord, so walk ye in him..."'></textarea>
                        @error('footer_quote_text') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-form-group" style="margin-top: 20px;">
                        <label class="admin-label">Verse / Quote Reference (Author)</label>
                        <input type="text" wire:model="footer_quote_author" class="admin-control" placeholder="e.g. Colossians 2:6-7">
                        @error('footer_quote_author') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>



            <!-- Right Side: Social Media & Profile Photo -->
            <div style="display: flex; flex-direction: column; gap: 24px; position: sticky; top: 24px; height: fit-content;">
                
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

                    <div class="admin-form-group">
                        <label class="admin-label">Twitter / X URL</label>
                        <input type="url" wire:model="twitter_link" class="admin-control" placeholder="https://twitter.com/username">
                        @error('twitter_link') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-label">YouTube Channel URL</label>
                        <input type="url" wire:model="youtube_link" class="admin-control" placeholder="https://youtube.com/@channel">
                        @error('youtube_link') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-label">Pinterest URL</label>
                        <input type="url" wire:model="pinterest_link" class="admin-control" placeholder="https://pinterest.com/username">
                        @error('pinterest_link') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <button type="submit" class="btn" style="width: 100%;">Save All Settings</button>

            </div>
        </div>
    </form>
</div>
