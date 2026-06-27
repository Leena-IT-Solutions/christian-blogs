<div class="container" style="max-width: 800px; padding: 40px 0 80px;">
    <!-- Post Header -->
    <article>
        <header style="border-bottom: none; position: static; backdrop-filter: none; background: none; text-align: center; margin-bottom: 32px; padding: 0;">
            <div style="margin-bottom: 12px;">
                @if ($post->category)
                    <span class="post-category" style="display: inline-block;">{{ $post->category->name }}</span>
                @endif
            </div>
            <h1 style="font-family: var(--font-heading); font-size: 2.8rem; line-height: 1.2; color: var(--text-color); margin-bottom: 16px;">
                {{ $post->title }}
            </h1>
            <div class="post-meta" style="justify-content: center; font-size: 0.9rem;">
                <span>By {{ $post->user->name ?? 'Admin' }}</span>
                <span>&bull;</span>
                <span>{{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}</span>
            </div>
        </header>

        @if ($post->featured_image)
            <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="post-detail-image">
        @endif

        <!-- Markdown Body -->
        <div class="post-body">
            <div class="raw-markdown-content" style="display: none;">{{ $post->body }}</div>
            <div class="parsed-markdown-html"></div>
        </div>

        <!-- Tags Cloud -->
        @if ($post->tags->isNotEmpty())
            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Tags:</span>
                @foreach ($post->tags as $tag)
                    <a href="/?tagSlug={{ $tag->slug }}" class="post-category" style="background-color: var(--border-color); color: var(--text-color); font-size: 0.75rem; text-transform: none;">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </article>

    <!-- Comments Section -->
    <div class="comments-section">
        <h3 style="font-family: var(--font-heading); font-size: 1.6rem; margin-bottom: 24px;">
            Discussion ({{ $post->approvedComments->count() }})
        </h3>

        <!-- Comments List -->
        <div class="comments-list">
            @forelse ($post->approvedComments as $comment)
                <div class="comment-card">
                    <div class="comment-header">
                        <span class="comment-author">{{ $comment->name }}</span>
                        <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <div style="color: var(--text-color); font-size: 0.95rem; line-height: 1.6; white-space: pre-wrap;">
                        {{ $comment->body }}
                    </div>
                </div>
            @empty
                <div class="comment-card" style="text-align: center; color: var(--text-muted); padding: 30px;">
                    No comments yet. Be the first to start the conversation!
                </div>
            @endforelse
        </div>

        <!-- Submit Comment Form -->
        <div style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 32px; box-shadow: var(--shadow-md);">
            <h4 style="font-family: var(--font-heading); font-size: 1.25rem; margin-bottom: 8px;">Leave a Comment</h4>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 24px;">Your email address will not be published. Required fields are marked *</p>

            @if (session()->has('comment_message'))
                <div class="badge badge-success" style="padding: 12px 20px; font-size: 0.85rem; margin-bottom: 24px; display: block; border-radius: var(--radius-sm); text-transform: none;">
                    {{ session('comment_message') }}
                </div>
            @endif

            <form wire:submit.prevent="submitComment" novalidate>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="comment-name" class="form-label">Name *</label>
                        <input 
                            type="text" 
                            id="comment-name" 
                            wire:model.blur="name" 
                            class="form-control" 
                            placeholder="Your Name" 
                            required
                            autocomplete="name"
                        >
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="comment-email" class="form-label">Email *</label>
                        <input 
                            type="email" 
                            id="comment-email" 
                            wire:model.blur="email" 
                            class="form-control" 
                            placeholder="your@email.com" 
                            required
                            autocomplete="email"
                        >
                        @error('email') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="comment-body" class="form-label">Comment *</label>
                    <textarea 
                        id="comment-body" 
                        wire:model.blur="body" 
                        class="form-control" 
                        style="height: 120px; resize: vertical;" 
                        placeholder="Write your thoughts..." 
                        required
                    ></textarea>
                    @error('body') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn" style="text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Submit Comment</button>
            </form>
        </div>
    </div>

    <!-- Client-side Markdown rendering -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        function parsePostMarkdown() {
            document.querySelectorAll('.parsed-markdown-html').forEach(el => {
                const rawSource = el.previousElementSibling.textContent;
                el.innerHTML = marked.parse(rawSource);
            });
        }
        document.addEventListener('DOMContentLoaded', parsePostMarkdown);
        document.addEventListener('livewire:navigated', parsePostMarkdown);
        setInterval(parsePostMarkdown, 300); // safety fallback
    </script>
</div>
