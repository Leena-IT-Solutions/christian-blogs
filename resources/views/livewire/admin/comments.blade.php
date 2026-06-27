<div>
    <div class="admin-header">
        <div class="admin-title">
            <h1>Comment Moderation</h1>
            <p>Approve or hide feedback submitted by visitors</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="badge badge-success" style="padding: 12px 20px; font-size: 0.9rem; margin-bottom: 24px; display: block; border-radius: var(--radius-sm);">
            {{ session('message') }}
        </div>
    @endif

    <div class="panel-card">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Author & Email</th>
                        <th>Comment Text</th>
                        <th>Article</th>
                        <th>Status</th>
                        <th style="width: 200px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comments as $comment)
                        <tr>
                            <td style="vertical-align: top; padding-top: 20px;">
                                <strong style="color: #ffffff; display: block; font-family: var(--font-heading);">{{ $comment->name }}</strong>
                                <span style="font-size: 0.8rem; color: var(--admin-text-muted);">{{ $comment->email }}</span>
                                <span style="font-size: 0.75rem; color: var(--admin-text-muted); display: block; margin-top: 6px;">{{ $comment->created_at->format('M d, Y H:i') }}</span>
                            </td>
                            <td style="vertical-align: top; padding-top: 20px; max-width: 350px;">
                                <div style="color: #dedede; font-style: italic; font-size: 0.95rem; line-height: 1.5; white-space: pre-line;">"{{ $comment->body }}"</div>
                            </td>
                            <td style="vertical-align: top; padding-top: 20px;">
                                @if ($comment->post)
                                    <a href="/posts/{{ $comment->post->slug }}" target="_blank" style="font-weight: 500;">{{ $comment->post->title }}</a>
                                @else
                                    <span style="color: var(--admin-text-muted); font-style: italic;">Deleted Post</span>
                                @endif
                            </td>
                            <td style="vertical-align: top; padding-top: 20px;">
                                @if ($comment->is_approved)
                                    <span class="badge badge-success">Approved</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td style="vertical-align: top; padding-top: 20px; text-align: right;">
                                <div class="btn-action-group" style="justify-content: flex-end;">
                                    @if ($comment->is_approved)
                                        <button wire:click="rejectComment({{ $comment->id }})" class="btn-icon" title="Reject / Hide Comment">Hide</button>
                                    @else
                                        <button wire:click="approveComment({{ $comment->id }})" class="btn-icon btn-icon-success" title="Approve Comment">Approve</button>
                                    @endif
                                    <button wire:click="deleteComment({{ $comment->id }})" 
                                        onclick="return confirm('Are you sure you want to delete this comment?');" 
                                        class="btn-icon btn-icon-danger" title="Delete Comment">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--admin-text-muted); padding: 40px;">
                                No comments submitted yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination Links -->
        @if ($comments->hasPages())
            <div style="display: flex; justify-content: center; gap: 8px; margin-top: 24px;">
                @if ($comments->onFirstPage())
                    <span class="btn-icon" style="opacity: 0.5; cursor: not-allowed;">&laquo; Previous</span>
                @else
                    <button wire:click="previousPage" class="btn-icon">&laquo; Previous</button>
                @endif

                <span class="btn-icon" style="border-color: var(--accent-color); color: var(--accent-color); font-weight: bold;">
                    Page {{ $comments->currentPage() }} of {{ $comments->lastPage() }}
                </span>

                @if ($comments->hasMorePages())
                    <button wire:click="nextPage" class="btn-icon">Next &raquo;</button>
                @else
                    <span class="btn-icon" style="opacity: 0.5; cursor: not-allowed;">Next &raquo;</span>
                @endif
            </div>
        @endif
    </div>
</div>
