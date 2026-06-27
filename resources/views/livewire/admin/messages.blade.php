<div>
    <div class="admin-header">
        <div class="admin-title">
            <h1>Inbox Messages</h1>
            <p>Read and manage contact form inquiries from your visitors</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="badge badge-success" style="padding: 12px 20px; font-size: 0.9rem; margin-bottom: 24px; display: block; border-radius: var(--radius-sm);">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid-1-1">
        
        <!-- Left Side: Inbox List -->
        <div class="panel-card" style="padding: 24px;">
            <h2 class="panel-title" style="margin-bottom: 16px; font-size: 1.15rem; text-transform: uppercase;">Inquiries ({{ $messages->total() }})</h2>
            
            <div style="display: flex; flex-direction: column; gap: 12px; max-height: 550px; overflow-y: auto; padding-right: 8px;">
                @forelse ($messages as $msg)
                    <div 
                        wire:click="selectMessage({{ $msg->id }})" 
                        style="padding: 16px; border: 1px solid {{ $activeMessageId === $msg->id ? 'var(--accent-color)' : 'var(--admin-border)' }}; 
                               background-color: {{ $activeMessageId === $msg->id ? 'var(--accent-light)' : 'var(--admin-bg)' }}; 
                               border-radius: var(--radius-md); cursor: pointer; transition: var(--transition);"
                    >
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                            <strong style="color: #ffffff; font-size: 0.95rem;">{{ $msg->name }}</strong>
                            <span style="font-size: 0.75rem; color: var(--admin-text-muted);">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <div style="font-weight: 600; font-size: 0.9rem; color: {{ $activeMessageId === $msg->id ? 'var(--accent-color)' : '#ffffff' }}; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $msg->subject ?? '(No Subject)' }}
                        </div>
                        <div style="font-size: 0.8rem; color: var(--admin-text-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ Str::limit($msg->message, 60) }}
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: var(--admin-text-muted); padding: 40px;">
                        Inbox is empty.
                    </div>
                @endforelse
            </div>

            <!-- Custom Pagination Links -->
            @if ($messages->hasPages())
                <div style="display: flex; justify-content: center; gap: 8px; margin-top: 24px;">
                    @if ($messages->onFirstPage())
                        <span class="btn-icon" style="opacity: 0.5; cursor: not-allowed;">&laquo;</span>
                    @else
                        <button wire:click="previousPage" class="btn-icon">&laquo;</button>
                    @endif

                    <span class="btn-icon" style="font-size: 0.8rem;">
                        {{ $messages->currentPage() }} / {{ $messages->lastPage() }}
                    </span>

                    @if ($messages->hasMorePages())
                        <button wire:click="nextPage" class="btn-icon">&raquo;</button>
                    @else
                        <span class="btn-icon" style="opacity: 0.5; cursor: not-allowed;">&raquo;</span>
                    @endif
                </div>
            @endif
        </div>

        <!-- Right Side: Message Detail Panel -->
        <div class="panel-card" style="min-height: 400px; padding: 32px; display: flex; flex-direction: column;">
            @if ($activeMessage)
                <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid var(--admin-border); padding-bottom: 16px; margin-bottom: 24px;">
                    <div>
                        <h2 style="font-family: var(--font-heading); font-size: 1.4rem; color: var(--accent-color); margin-bottom: 6px;">{{ $activeMessage->subject ?? '(No Subject)' }}</h2>
                        <div style="font-size: 0.9rem;">
                            <span style="color: var(--admin-text-muted);">From:</span> <strong>{{ $activeMessage->name }}</strong> 
                            <span style="color: var(--admin-text-muted); margin-left: 6px;">&lt;{{ $activeMessage->email }}&gt;</span>
                        </div>
                    </div>
                    <button wire:click="deleteMessage({{ $activeMessage->id }})" 
                        onclick="return confirm('Are you sure you want to delete this message?');" 
                        class="btn-icon btn-icon-danger" style="padding: 8px 16px;">
                        Delete
                    </button>
                </div>
                
                <div style="flex-grow: 1; color: #dedede; font-size: 1rem; line-height: 1.7; white-space: pre-wrap; font-family: var(--font-body);">
                    {{ $activeMessage->message }}
                </div>
                
                <div style="font-size: 0.8rem; color: var(--admin-text-muted); border-top: 1px solid var(--admin-border); padding-top: 16px; margin-top: 24px;">
                    Received on {{ $activeMessage->created_at->format('l, F j, Y \a\t g:i A') }}
                </div>
            @else
                <div style="flex-grow: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; color: var(--admin-text-muted);">
                    <svg style="width: 48px; height: 48px; margin-bottom: 16px; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l8-5.333a2 2 0 012.22 0l8 5.333A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-2.25-1.5a2 2 0 00-2.22 0l-2.25 1.5" />
                    </svg>
                    <p>Select a message from the inbox listing to read its contents</p>
                </div>
            @endif
        </div>

    </div>
</div>
