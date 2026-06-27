<div class="container">
    <div class="main-grid">
        
        <!-- Left Side: Contact Form -->
        <div>
            <div class="contact-container" style="margin: 0; max-width: 100%;">
                
                <h1 style="font-family: var(--font-heading); text-align: center; color: var(--text-color); margin-bottom: 8px;">Contact Me</h1>
                <p style="text-align: center; color: var(--text-muted); margin-bottom: 40px; font-size: 1.05rem;">
                    Have a question, feedback, or a prayer request? Leave a message below.
                </p>

                <form wire:submit.prevent="submitForm" novalidate>
                    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="name" class="form-label">Full Name</label>
                            <input 
                                type="text" 
                                id="name" 
                                wire:model.blur="name" 
                                class="form-control" 
                                placeholder="John Doe" 
                                required
                                autocomplete="name"
                            >
                            @error('name') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                wire:model.blur="email" 
                                class="form-control" 
                                placeholder="john@example.com" 
                                required
                                autocomplete="email"
                            >
                            @error('email') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject" class="form-label">Subject</label>
                        <input 
                            type="text" 
                            id="subject" 
                            wire:model.blur="subject" 
                            class="form-control" 
                            placeholder="e.g. Prayer Request, Partnership Inquiry"
                        >
                        @error('subject') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea 
                            id="message" 
                            wire:model.blur="message" 
                            class="form-control" 
                            style="height: 150px; resize: vertical;" 
                            placeholder="Write your message here... (minimum 10 characters)"
                            required
                        ></textarea>
                        @error('message') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn" style="width: 100%; margin-top: 10px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <span wire:loading.remove wire:target="submitForm">Send Message</span>
                        <span wire:loading wire:target="submitForm">Sending Message...</span>
                    </button>
                </form>

            </div>
        </div>

        <!-- Right Side: Sidebar -->
        <div class="sidebar">
            <!-- About Author Widget -->
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

    <!-- Success Modal Overlay -->
    @if ($showSuccessModal)
        <div class="overlay" onclick="if(event.target === this) @this.call('closeSuccessModal')">
            <div class="overlay-content" style="max-width: 500px; text-align: center; padding: 40px;">
                <button wire:click="closeSuccessModal" class="close-btn" aria-label="Close modal">&times;</button>
                
                <div style="background-color: var(--accent-light); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; border: 2px solid var(--accent-color);">
                    <svg style="width: 40px; height: 40px; color: var(--accent-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <h2 style="font-family: var(--font-heading); margin-bottom: 12px; color: var(--text-color);">Message Sent!</h2>
                <p style="color: var(--text-muted); margin-bottom: 24px; line-height: 1.6;">
                    Thank you for reaching out. Your message has been safely received, and I will read it as soon as possible.
                </p>
                
                <button wire:click="closeSuccessModal" class="btn" style="padding: 10px 30px; font-size: 0.95rem;">Done</button>
            </div>
        </div>
    @endif
</div>
