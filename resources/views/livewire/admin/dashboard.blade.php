<div>
    <div class="admin-header">
        <div class="admin-title">
            <h1>Dashboard</h1>
            <p>Welcome back, Admin. Here is your website's performance overview.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">Published Posts</span>
            <span class="stat-value">{{ $stats['posts_published'] }} <span style="font-size: 1rem; color: var(--admin-text-muted); font-weight: normal;">/ {{ $stats['posts_total'] }} total</span></span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Draft Posts</span>
            <span class="stat-value">{{ $stats['posts_draft'] }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Categories</span>
            <span class="stat-value">{{ $stats['categories'] }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Tags</span>
            <span class="stat-value">{{ $stats['tags'] }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Pending Comments</span>
            <span class="stat-value" style="{{ $stats['comments_pending'] > 0 ? 'color: #fbbf24;' : '' }}">{{ $stats['comments_pending'] }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Total Messages</span>
            <span class="stat-value">{{ $stats['messages_unread'] }}</span>
        </div>
    </div>

    <!-- Quick Links Widget -->
    <div class="panel-card">
        <div class="panel-header">
            <h2 class="panel-title">Quick Administrative Actions</h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <a href="/admin/posts/create" class="btn" style="text-align: center; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Write New Post</a>
            <a href="/admin/comments" class="btn btn-secondary" style="text-align: center; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Moderate Comments</a>
            <a href="/admin/settings" class="btn btn-secondary" style="text-align: center; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Edit Site Settings</a>
            <a href="/" class="btn btn-secondary" style="text-align: center; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; border-color: var(--accent-color); color: var(--accent-color);">Visit Public Site</a>
        </div>
    </div>

    <!-- System Update Widget -->
    <div class="panel-card" style="margin-top: 24px;">
        <style>
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .spinner-icon {
                animation: spin 1s linear infinite;
            }
        </style>
        
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--admin-border); padding-bottom: 12px; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
            <h2 class="panel-title" style="margin-bottom: 0;">System Update</h2>
            <span style="font-size: 0.85rem; color: var(--admin-text-muted); background: var(--admin-bg-side); padding: 4px 10px; border-radius: var(--radius-sm); border: 1px solid var(--admin-border);">
                <strong>Current Version:</strong> {{ $currentCommit }}
            </span>
        </div>
        
        <p style="font-size: 0.9rem; color: var(--admin-text-muted); margin-bottom: 20px; line-height: 1.5;">
            Click the button below to pull the latest code changes from the GitHub repository, run any new database migrations, and clear application caches.
        </p>

        @if (session()->has('update_message'))
            <div class="badge badge-success" style="padding: 12px 20px; font-size: 0.9rem; margin-bottom: 20px; display: block; border-radius: var(--radius-sm);">
                {{ session('update_message') }}
            </div>
        @endif

        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div>
                <button 
                    wire:click="updateSite" 
                    wire:loading.attr="disabled"
                    class="btn" 
                    style="padding: 10px 24px; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 8px;"
                >
                    <svg wire:loading.remove wire:target="updateSite" style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15H18" />
                    </svg>
                    <span wire:loading wire:target="updateSite" class="spinner-icon" style="border: 2px solid #fff; border-top: 2px solid transparent; border-radius: 50%; width: 14px; height: 14px; display: inline-block; box-sizing: border-box;"></span>
                    <span wire:loading.remove wire:target="updateSite">Update from GitHub</span>
                    <span wire:loading wire:target="updateSite">Updating Site...</span>
                </button>
            </div>

            @if ($updateOutput)
                <div style="margin-top: 10px;">
                    <label class="admin-label" style="font-weight: 600; margin-bottom: 8px; display: block;">Update Console Output:</label>
                    <pre style="background-color: #1a1a1a; color: #a9b7c6; padding: 16px; border-radius: var(--radius-sm); font-family: monospace; font-size: 0.85rem; overflow-x: auto; max-height: 300px; overflow-y: auto; white-space: pre-wrap; border: 1px solid var(--admin-border); line-height: 1.4;">{{ $updateOutput }}</pre>
                </div>
            @endif
        </div>
    </div>
</div>
