<div>
    <div class="admin-header" style="display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap;">
        <div class="admin-title">
            <h1>SEO Settings</h1>
            <p>Manage search engine optimization parameters for primary public pages</p>
        </div>
        <button type="submit" form="seo-form" class="btn" style="padding: 10px 24px;">Save SEO</button>
    </div>

    @if (session()->has('message'))
        <div class="badge badge-success" style="padding: 12px 20px; font-size: 0.9rem; margin-bottom: 24px; display: block; border-radius: var(--radius-sm);">
            {{ session('message') }}
        </div>
    @endif

    <form id="seo-form" wire:submit.prevent="saveSeo">
        <div class="grid-2-1">
            
            <!-- Left Side: SEO configurations -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                
                <!-- Home SEO -->
                <div class="panel-card" style="margin-bottom: 0;">
                    <h2 class="panel-title" style="margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Home Page SEO</h2>
                    
                    <div class="admin-form-group">
                        <label class="admin-label">Meta Title (Fallback: Site Title + Subtitle)</label>
                        <input type="text" wire:model="seo_home_title" class="admin-control" placeholder="e.g. Be Rooted in Christ — Devotional Blog">
                        @error('seo_home_title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="admin-form-group" style="margin-top: 20px;">
                        <label class="admin-label">Meta Description</label>
                        <textarea wire:model="seo_home_description" class="admin-control" style="height: 100px; resize: vertical;" placeholder="Brief summary of your homepage for search results..."></textarea>
                        @error('seo_home_description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="admin-form-group" style="margin-top: 20px;">
                        <label class="admin-label">Meta Keywords (Comma separated)</label>
                        <input type="text" wire:model="seo_home_keywords" class="admin-control" placeholder="e.g. faith, devotionals, Bible study">
                        @error('seo_home_keywords') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- About SEO -->
                <div class="panel-card" style="margin-bottom: 0;">
                    <h2 class="panel-title" style="margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">About Page SEO</h2>
                    
                    <div class="admin-form-group">
                        <label class="admin-label">Meta Title (Fallback: About the Author — Site Title)</label>
                        <input type="text" wire:model="seo_about_title" class="admin-control" placeholder="e.g. About the Author — Be Rooted in Christ">
                        @error('seo_about_title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="admin-form-group" style="margin-top: 20px;">
                        <label class="admin-label">Meta Description</label>
                        <textarea wire:model="seo_about_description" class="admin-control" style="height: 100px; resize: vertical;" placeholder="Brief summary of your author bio page for search results..."></textarea>
                        @error('seo_about_description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="admin-form-group" style="margin-top: 20px;">
                        <label class="admin-label">Meta Keywords (Comma separated)</label>
                        <input type="text" wire:model="seo_about_keywords" class="admin-control" placeholder="e.g. author bio, Christian blogger">
                        @error('seo_about_keywords') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Contact SEO -->
                <div class="panel-card" style="margin-bottom: 0;">
                    <h2 class="panel-title" style="margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Contact Page SEO</h2>
                    
                    <div class="admin-form-group">
                        <label class="admin-label">Meta Title (Fallback: Contact — Site Title)</label>
                        <input type="text" wire:model="seo_contact_title" class="admin-control" placeholder="e.g. Contact — Be Rooted in Christ">
                        @error('seo_contact_title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="admin-form-group" style="margin-top: 20px;">
                        <label class="admin-label">Meta Description</label>
                        <textarea wire:model="seo_contact_description" class="admin-control" style="height: 100px; resize: vertical;" placeholder="Brief summary of your contact page for search results..."></textarea>
                        @error('seo_contact_description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="admin-form-group" style="margin-top: 20px;">
                        <label class="admin-label">Meta Keywords (Comma separated)</label>
                        <input type="text" wire:model="seo_contact_keywords" class="admin-control" placeholder="e.g. contact details, prayer request form">
                        @error('seo_contact_keywords') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Social Share Image -->
                <div class="panel-card" style="margin-bottom: 0;">
                    <h2 class="panel-title" style="margin-bottom: 20px; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">Default Social Sharing Image (OG Image)</h2>
                    <p style="font-size: 0.9rem; color: var(--admin-text-muted); margin-bottom: 15px;">
                        This image is shown when you share links to your website on social networks like WhatsApp, Facebook, Twitter, etc. Individual blog posts will automatically use their own featured images, while other pages (like Home, About, and Contact) will fall back to this image.
                    </p>
                    
                    <div class="admin-form-group">
                        <label class="admin-label">Upload Sharing Image (Leave blank to keep current)</label>
                        <div style="display: flex; align-items: center; gap: 20px; margin-top: 10px; flex-wrap: wrap;">
                            @if ($og_image)
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span style="font-size: 0.75rem; color: #4ade80; font-weight: 600;">Previewing Uploaded:</span>
                                    <img src="{{ $og_image->temporaryUrl() }}" style="max-height: 120px; width: auto; object-fit: contain; border: 1px solid var(--admin-border); padding: 4px; border-radius: var(--radius-sm);" alt="OG Image Preview">
                                </div>
                            @elseif ($existing_og_image)
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span style="font-size: 0.75rem; color: var(--accent-color); font-weight: 600;">Current Sharing Image:</span>
                                    <img src="{{ asset($existing_og_image) }}" style="max-height: 120px; width: auto; object-fit: contain; border: 1px solid var(--admin-border); padding: 4px; border-radius: var(--radius-sm);" alt="Current OG Image">
                                </div>
                            @else
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span style="font-size: 0.75rem; color: var(--admin-text-muted); font-weight: 600;">Default Sharing Image:</span>
                                    <img src="{{ asset('images/og-default.jpg') }}" style="max-height: 120px; width: auto; object-fit: contain; border: 1px solid var(--admin-border); padding: 4px; border-radius: var(--radius-sm); opacity: 0.7;" alt="Default OG Image">
                                </div>
                            @endif
                            
                            <div style="flex-grow: 1; min-width: 200px;">
                                <input type="file" wire:model="og_image" accept="image/*" class="admin-control" style="padding: 8px;">
                                <div wire:loading wire:target="og_image" style="font-size: 0.85rem; color: var(--accent-color); margin-top: 4px;">Uploading...</div>
                            </div>
                        </div>
                        <small style="color: var(--admin-text-muted); display: block; margin-top: 8px;">Recommended dimensions: 1200x630 pixels (aspect ratio 1.91:1) for optimal rendering across WhatsApp, Facebook, and Twitter. Max size: 5MB.</small>
                        @error('og_image') <span class="invalid-feedback" style="display: block; margin-top: 8px;">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>

            <!-- Right Side: Sidebar info & submit button -->
            <div style="display: flex; flex-direction: column; gap: 24px; position: sticky; top: 24px; height: fit-content;">
                <div class="panel-card" style="margin-bottom: 0;">
                    <h3 class="panel-title" style="font-size: 1.15rem; margin-bottom: 16px; text-transform: uppercase; border-bottom: 1px solid var(--admin-border); padding-bottom: 8px;">SEO Guidelines</h3>
                    <p style="font-size: 0.9rem; color: var(--admin-text-muted); margin-bottom: 12px; line-height: 1.5;">
                        Configure indexing metadata tags to tell search engines (like Google) how to represent your website pages.
                    </p>
                    <ul style="font-size: 0.85rem; color: var(--admin-text-muted); margin-left: 16px; display: flex; flex-direction: column; gap: 8px;">
                        <li><strong>Title:</strong> Keep titles under 60 characters for optimal rendering on search results.</li>
                        <li><strong>Description:</strong> Descriptions should ideally be between 120 and 160 characters.</li>
                        <li><strong>Keywords:</strong> Comma-separated search terms that describe the content.</li>
                    </ul>
                </div>

                <button type="submit" class="btn" style="width: 100%;">Save SEO Configuration</button>
            </div>

        </div>
    </form>
</div>
