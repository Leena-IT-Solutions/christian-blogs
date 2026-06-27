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
            <a href="/" target="_blank" class="btn btn-secondary" style="text-align: center; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; border-color: var(--accent-color); color: var(--accent-color);">Visit Public Site</a>
        </div>
    </div>
</div>
