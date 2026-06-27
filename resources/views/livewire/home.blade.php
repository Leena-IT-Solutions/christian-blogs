<div>
    <!-- Hero Header -->
    <div class="hero container">
        <h1 style="font-family: var(--font-heading); color: var(--text-color);">Planted to Prevail</h1>
        <p style="font-family: var(--font-heading); font-style: italic; color: var(--accent-color); font-size: 1.15rem; max-width: 600px; margin: 0 auto;">
            Sowing seeds of Truth, nurturing roots of faith, and bearing fruit for the glory of Christ.
        </p>
    </div>

    <div class="container">
        <div class="main-grid">
            
            <!-- Left Column: Posts Feed -->
            <div>
                <!-- Search & Filters -->
                <div class="search-container">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        class="search-input" 
                        placeholder="Search devotionals, studies, reflections..."
                    >
                </div>

                @if ($search || $categorySlug || $tagSlug)
                    <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; margin-bottom: 24px;">
                        <span style="font-size: 0.9rem; color: var(--text-muted);">Active Filters:</span>
                        @if ($search)
                            <span class="post-category" style="background-color: var(--border-color); color: var(--text-color); text-transform: none;">
                                Search: "{{ $search }}"
                            </span>
                        @endif
                        @if ($categorySlug)
                            <span class="post-category">
                                Category: {{ str_replace('-', ' ', $categorySlug) }}
                            </span>
                        @endif
                        @if ($tagSlug)
                            <span class="post-category" style="background-color: #313131; color: #ffffff;">
                                Tag: #{{ $tagSlug }}
                            </span>
                        @endif
                        <button wire:click="clearFilters" style="background: none; border: none; color: var(--accent-color); cursor: pointer; font-size: 0.9rem; font-weight: 600; text-decoration: underline;">
                            Clear All
                        </button>
                    </div>
                @endif

                <!-- Articles Grid -->
                <div class="posts-grid">
                    @forelse ($posts as $post)
                        <article class="post-card">
                            @if ($post->featured_image)
                                <div class="post-image-container" wire:click="showPost({{ $post->id }})" style="cursor: pointer;">
                                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}">
                                </div>
                            @endif

                            <div class="post-content">
                                <div class="post-meta">
                                    @if ($post->category)
                                        <span class="post-category" wire:click="filterByCategory('{{ $post->category->slug }}')" style="cursor: pointer;">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                    <span>
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}
                                    </span>
                                    <span>
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        {{ $post->comments_count ?? $post->approvedComments()->count() }} Comments
                                    </span>
                                </div>

                                <h2 class="post-title">
                                    <a href="javascript:void(0)" wire:click="showPost({{ $post->id }})">{{ $post->title }}</a>
                                </h2>

                                <p class="post-excerpt">
                                    {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 150) }}
                                </p>

                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                                    <button wire:click="showPost({{ $post->id }})" class="read-more-btn">Read Article</button>
                                    <a href="/posts/{{ $post->slug }}" style="font-size: 0.9rem; font-weight: 600; text-decoration: underline;">View Full &amp; Comment</a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="post-card" style="padding: 48px; text-align: center; color: var(--text-muted);">
                            <p style="font-size: 1.1rem; margin-bottom: 0;">No articles found matching your criteria. Try adjusting your search query.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Custom Pagination -->
                @if ($posts->hasPages())
                    <div class="pagination">
                        @if ($posts->onFirstPage())
                            <span class="pagination-item disabled">&laquo; Prev</span>
                        @else
                            <button wire:click="previousPage" class="pagination-item" style="background: none; border: 1px solid var(--border-color); cursor: pointer;">&laquo; Prev</button>
                        @endif

                        <span class="pagination-item active" style="background-color: var(--accent-color); border-color: var(--accent-color); color: #ffffff;">
                            {{ $posts->currentPage() }} / {{ $posts->lastPage() }}
                        </span>

                        @if ($posts->hasMorePages())
                            <button wire:click="nextPage" class="pagination-item" style="background: none; border: 1px solid var(--border-color); cursor: pointer;">Next &raquo;</button>
                        @else
                            <span class="pagination-item disabled">Next &raquo;</span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Right Column: Sidebar -->
            <div class="sidebar">
                <!-- About Widget -->
                <div class="sidebar-widget" style="text-align: center;">
                    <h3 class="widget-title">The Author</h3>
                    @php
                        $authorPhoto = \App\Models\Setting::where('key', 'about_image')->value('value');
                        $authorBio = \App\Models\Setting::where('key', 'about_text')->value('value');
                    @endphp
                    @if ($authorPhoto)
                        <img src="{{ asset($authorPhoto) }}" alt="Author" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 16px; border: 2px solid var(--accent-color);">
                    @endif
                    <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 16px;">
                        {{ Str::limit(strip_tags($authorBio), 120) }}
                    </p>
                    <a href="/about" style="font-size: 0.85rem; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">Read Full Biography &raquo;</a>
                </div>

                <!-- Categories Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Categories</h3>
                    <ul class="category-list">
                        @foreach ($categories as $cat)
                            <li>
                                <a href="javascript:void(0)" wire:click="filterByCategory('{{ $cat->slug }}')" class="{{ $categorySlug === $cat->slug ? 'active' : '' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="category-count">{{ $cat->posts_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tags Widget -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Tags</h3>
                    <div class="tag-cloud">
                        @foreach ($tags as $tag)
                            <a href="javascript:void(0)" wire:click="filterByTag('{{ $tag->slug }}')" class="{{ $tagSlug === $tag->slug ? 'active' : '' }}">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Glassmorphic Post Detail Overlay -->
    @if ($activePost)
        <div class="overlay" onclick="if(event.target === this) @this.call('closePost')">
            <div class="overlay-content">
                <button wire:click="closePost" class="close-btn" aria-label="Close modal">&times;</button>
                
                <div class="post-detail-header">
                    <span class="post-category" style="margin-bottom: 12px; display: inline-block;">{{ $activePost->category->name ?? 'Devotional' }}</span>
                    <h1 style="color: var(--text-color);">{{ $activePost->title }}</h1>
                    
                    <div style="font-size: 0.9rem; color: var(--text-muted); display: flex; justify-content: center; gap: 16px; margin-top: 12px;">
                        <span>By {{ $activePost->user->name ?? 'Admin' }}</span>
                        <span>&bull;</span>
                        <span>{{ $activePost->published_at ? $activePost->published_at->format('F d, Y') : $activePost->created_at->format('F d, Y') }}</span>
                    </div>
                </div>

                @if ($activePost->featured_image)
                    <img src="{{ asset($activePost->featured_image) }}" alt="" class="post-detail-image">
                @endif

                <!-- Markdown Content Rendered Here -->
                <div class="post-body">
                    <div class="raw-markdown-content" style="display: none;">{{ $activePost->body }}</div>
                    <div class="parsed-markdown-html"></div>
                </div>

                <div style="margin-top: 40px; border-top: 1px solid var(--border-color); padding-top: 24px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.95rem; color: var(--text-muted);">
                        Want to discuss this devotional?
                    </span>
                    <a href="/posts/{{ $activePost->slug }}" class="btn" style="padding: 10px 24px; font-size: 0.9rem;">View Comments &amp; Reply</a>
                </div>
            </div>
        </div>
    @endif

    <!-- Client-side Markdown rendering for visitors -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        function parseAllMarkdown() {
            // Parse body contents
            document.querySelectorAll('.parsed-markdown-html').forEach(el => {
                const rawSource = el.previousElementSibling.textContent;
                el.innerHTML = marked.parse(rawSource);
            });
        }

        // Render on page load
        document.addEventListener('DOMContentLoaded', parseAllMarkdown);
        
        // Listen to Livewire page updates/modal triggers to parse markdown
        document.addEventListener('livewire:navigated', parseAllMarkdown);
        
        // When activePost is set, Livewire renders the modal. We must parse it immediately
        window.addEventListener('livewire:load', () => {
            Livewire.hook('morph.updated', ({ el, component }) => {
                parseAllMarkdown();
            });
        });
        
        // General backup interval to catch rendering
        setInterval(parseAllMarkdown, 300);
    </script>
</div>
