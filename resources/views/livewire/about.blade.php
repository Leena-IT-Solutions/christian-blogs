<div class="container">
    <div class="main-grid">
        
        <!-- Left Side: About Content -->
        <div>
            <div class="about-container" style="margin: 0; max-width: 100%;">
                
                <!-- Author Profile Section -->
                <div class="profile-section">
                    @if ($profilePhoto)
                        <img src="{{ asset($profilePhoto) }}" alt="Author Profile" class="profile-image">
                    @else
                        <div style="width: 180px; height: 180px; border-radius: 50%; background-color: var(--border-color); display: flex; align-items: center; justify-content: center; margin-bottom: 24px; border: 4px solid var(--accent-color);">
                            <svg style="width: 60px; height: 60px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    @endif
                    
                    <h1 style="font-family: var(--font-heading); color: var(--text-color); margin-bottom: 8px;">About the Author</h1>
                    <p style="font-family: var(--font-heading); font-style: italic; color: var(--accent-color); font-size: 1.1rem; margin-bottom: 20px;">Planted to Prevail &amp; Produce</p>
                    
                    <!-- Social Links -->
                    @if ($facebookLink || $instagramLink)
                        <div style="display: flex; gap: 16px; margin-top: 10px;">
                            @if ($facebookLink)
                                <a href="{{ $facebookLink }}" target="_blank" class="btn btn-secondary" style="padding: 6px 16px; font-size: 0.85rem; display: flex; align-items: center; gap: 6px;">
                                    Facebook
                                </a>
                            @endif
                            @if ($instagramLink)
                                <a href="{{ $instagramLink }}" target="_blank" class="btn btn-secondary" style="padding: 6px 16px; font-size: 0.85rem; display: flex; align-items: center; gap: 6px;">
                                    Instagram
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Biography Text (Markdown parsed) -->
                <div style="border-top: 1px solid var(--border-color); padding-top: 40px; margin-top: 20px;">
                    <div class="raw-markdown-content" style="display: none;">{{ $biography }}</div>
                    <div class="parsed-markdown-html post-body"></div>
                </div>

            </div>
        </div>

        <!-- Right Side: Sidebar -->
        <div class="sidebar">
            <!-- Categories Widget -->
            <div class="sidebar-widget">
                <h3 class="widget-title">Categories</h3>
                <ul class="category-list">
                    @foreach ($categories as $cat)
                        <li>
                            <a href="/?categorySlug={{ $cat->slug }}">
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
                        <a href="/?tagSlug={{ $tag->slug }}">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <!-- Client-side Markdown rendering -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        function parseAboutMarkdown() {
            document.querySelectorAll('.parsed-markdown-html').forEach(el => {
                const rawSource = el.previousElementSibling.textContent;
                el.innerHTML = marked.parse(rawSource);
            });
        }
        document.addEventListener('DOMContentLoaded', parseAboutMarkdown);
        document.addEventListener('livewire:navigated', parseAboutMarkdown);
        setInterval(parseAboutMarkdown, 300); // safety fallback
    </script>
</div>
