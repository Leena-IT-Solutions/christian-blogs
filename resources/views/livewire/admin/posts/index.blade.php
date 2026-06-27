<div>
    <div class="admin-header">
        <div class="admin-title">
            <h1>Posts</h1>
            <p>Write, update, and manage your articles</p>
        </div>
        <a href="/admin/posts/create" class="btn">Write New Post</a>
    </div>

    @if (session()->has('message'))
        <div class="badge badge-success" style="padding: 12px 20px; font-size: 0.9rem; margin-bottom: 24px; display: block; border-radius: var(--radius-sm);">
            {{ session('message') }}
        </div>
    @endif

    <!-- Filters Panel -->
    <div class="panel-card" style="padding: 20px; margin-bottom: 24px;">
        <div class="grid-2-1" style="gap: 16px;">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                class="admin-control" 
                placeholder="Search articles by title or content..."
            >
            <select wire:model.live="status" class="admin-control">
                <option value="">All Statuses</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>
    </div>

    <!-- Posts Table -->
    <div class="panel-card">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th style="width: 150px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>
                                @if ($post->featured_image)
                                    <img src="{{ asset($post->featured_image) }}" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--admin-border);">
                                @else
                                    <div style="width: 60px; height: 40px; background-color: var(--admin-bg); border-radius: var(--radius-sm); border: 1px solid var(--admin-border); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: var(--admin-text-muted);">None</div>
                                @endif
                            </td>
                            <td>
                                <strong style="color: #ffffff; font-size: 1rem; display: block;">{{ $post->title }}</strong>
                                <span style="font-size: 0.8rem; color: var(--admin-text-muted);">By {{ $post->user->name ?? 'Admin' }}</span>
                            </td>
                            <td>
                                <span style="color: var(--accent-color); font-weight: 500;">{{ $post->category->name ?? 'Uncategorized' }}</span>
                            </td>
                            <td>
                                @if ($post->status === 'published')
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                @if ($post->status === 'published')
                                    <span style="font-size: 0.85rem; color: var(--admin-text-muted);">Published: {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                @else
                                    <span style="font-size: 0.85rem; color: var(--admin-text-muted);">Created: {{ $post->created_at->format('M d, Y') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-action-group" style="justify-content: flex-end;">
                                    <a href="/admin/posts/{{ $post->id }}/edit" class="btn-icon" style="display: inline-block;">Edit</a>
                                    <button wire:click="deletePost({{ $post->id }})" 
                                        onclick="return confirm('Are you sure you want to delete this post?');" 
                                        class="btn-icon btn-icon-danger">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--admin-text-muted); padding: 40px;">
                                No articles found. Write your first post!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination Links -->
        @if ($posts->hasPages())
            <div style="display: flex; justify-content: center; gap: 8px; margin-top: 24px;">
                {{-- Previous Page Link --}}
                @if ($posts->onFirstPage())
                    <span class="btn-icon" style="opacity: 0.5; cursor: not-allowed;">&laquo; Previous</span>
                @else
                    <button wire:click="previousPage" class="btn-icon">&laquo; Previous</button>
                @endif

                {{-- Page Numbers --}}
                <span class="btn-icon" style="border-color: var(--accent-color); color: var(--accent-color); font-weight: bold;">
                    Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}
                </span>

                {{-- Next Page Link --}}
                @if ($posts->hasMorePages())
                    <button wire:click="nextPage" class="btn-icon">Next &raquo;</button>
                @else
                    <span class="btn-icon" style="opacity: 0.5; cursor: not-allowed;">Next &raquo;</span>
                @endif
            </div>
        @endif
    </div>
</div>
