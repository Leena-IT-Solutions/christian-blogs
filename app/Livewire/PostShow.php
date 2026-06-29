<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Setting;
use Livewire\Component;

class PostShow extends Component
{
    public $post;

    // Comment Form Fields
    public $name = '';
    public $email = '';
    public $body = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'body' => 'required|string|min:3|max:2000',
    ];

    public function mount($slug)
    {
        $this->post = Post::with(['category', 'tags', 'approvedComments', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
    }

    public function submitComment()
    {
        $this->validate();

        Comment::create([
            'post_id' => $this->post->id,
            'name'    => $this->name,
            'email'   => $this->email,
            'body'    => $this->body,
            'is_approved' => false, // Requires manual moderation
        ]);

        $this->reset(['name', 'email', 'body']);
        session()->flash('comment_message', 'Thank you. Your comment has been submitted and is awaiting moderation.');
    }

    public function render()
    {
        $post = $this->post;
        $siteTitle = Setting::getVal('site_title', 'Be Rooted in Christ');

        // --- SEO Data ---
        $excerpt      = $post->excerpt ?? \Str::limit(strip_tags($post->body), 155);
        $canonical    = url('/posts/' . $post->slug);
        $defaultOgImageSetting = Setting::getVal('og_image');
        $defaultOgImage = $defaultOgImageSetting ? asset($defaultOgImageSetting) : asset('images/og-default.jpg');
        $ogImage      = $post->featured_image ? asset($post->featured_image) : $defaultOgImage;
        $publishedAt  = $post->published_at ?? $post->created_at;
        $updatedAt    = $post->updated_at;
        $category     = $post->category->name ?? 'Devotional';
        $tagNames     = $post->tags->pluck('name')->toArray();
        $authorName   = $post->user->name ?? $siteTitle;
        $keywords     = implode(', ', array_merge([$siteTitle, 'Christian blog', $category], $tagNames));

        // --- JSON-LD: BlogPosting + BreadcrumbList ---
        $blogPosting = json_encode([
            '@context'         => 'https://schema.org',
            '@type'            => 'BlogPosting',
            '@id'              => $canonical,
            'headline'         => $post->title,
            'description'      => $excerpt,
            'url'              => $canonical,
            'datePublished'    => $publishedAt->toIso8601String(),
            'dateModified'     => $updatedAt->toIso8601String(),
            'inLanguage'       => 'en-IN',
            'image'            => ['@type' => 'ImageObject', 'url' => $ogImage, 'width' => 1200, 'height' => 630],
            'author'           => ['@type' => 'Person', 'name' => $authorName, 'url' => url('/about')],
            'publisher'        => [
                '@type' => 'Organization',
                '@id'   => url('/') . '/#organization',
                'name'  => $siteTitle,
                'url'   => url('/'),
                'logo'  => ['@type' => 'ImageObject', 'url' => $defaultOgImage, 'width' => 1200, 'height' => 630],
            ],
            'articleSection'   => $category,
            'keywords'         => $keywords,
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonical],
            'isPartOf'         => ['@type' => 'Blog', '@id' => url('/') . '/#blog', 'name' => $siteTitle . ' Blog', 'url' => url('/')],
            'commentCount'     => $post->approvedComments->count(),
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $breadcrumb = json_encode([
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $category, 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => $canonical],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $jsonLd = '<script type="application/ld+json">' . $blogPosting . '</script>' . "\n"
                . '<script type="application/ld+json">' . $breadcrumb . '</script>';

        return view('livewire.post-show')
            ->layout('components.layouts.app', [
                'title'                => $post->title . ' — ' . $siteTitle,
                'description'          => $excerpt,
                'keywords'             => $keywords,
                'canonical'            => $canonical,
                'ogType'               => 'article',
                'ogTitle'              => $post->title . ' — ' . $siteTitle,
                'ogDescription'        => $excerpt,
                'ogImage'              => $ogImage,
                'articlePublishedTime' => $publishedAt->toIso8601String(),
                'articleModifiedTime'  => $updatedAt->toIso8601String(),
                'articleSection'       => $category,
                'articleTags'          => $tagNames,
                'twitterCard'          => 'summary_large_image',
                'jsonLd'               => $jsonLd,
            ]);
    }
}
