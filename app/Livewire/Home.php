<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Setting;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $categorySlug = '';
    public $tagSlug = '';

    // Active post for overlay/modal
    public $activePostId = null;

    protected $queryString = [
        'search'       => ['except' => ''],
        'categorySlug' => ['except' => ''],
        'tagSlug'      => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filterByCategory($slug)
    {
        $this->categorySlug = $slug;
        $this->tagSlug = '';
        $this->resetPage();
    }

    public function filterByTag($slug)
    {
        $this->tagSlug = $slug;
        $this->categorySlug = '';
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'categorySlug', 'tagSlug']);
        $this->resetPage();
    }

    public function showPost($id)
    {
        $this->activePostId = $id;
    }

    public function closePost()
    {
        $this->activePostId = null;
    }

    public function render()
    {
        $posts = Post::with(['category', 'tags', 'user'])
            ->where('status', 'published')
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('body', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categorySlug, function ($query) {
                $query->whereHas('category', function ($sub) {
                    $sub->where('slug', $this->categorySlug);
                });
            })
            ->when($this->tagSlug, function ($query) {
                $query->whereHas('tags', function ($sub) {
                    $sub->where('slug', $this->tagSlug);
                });
            })
            ->orderBy('published_at', 'desc')
            ->paginate(5);

        // Sidebar data
        $categories = Category::withCount(['posts' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        $tags = Tag::has('posts')->get();

        // Selected post for modal
        $activePost = $this->activePostId ? Post::with(['category', 'tags', 'approvedComments'])->find($this->activePostId) : null;

        $siteTitle = Setting::getVal('site_title', 'Be Rooted in Christ');
        $siteSubtitle = Setting::getVal('site_subtitle', 'Planted to Prevail & Produce');

        $seoTitle = Setting::getVal('seo_home_title') ?: ($siteTitle . ' — Devotional Blog | ' . $siteSubtitle);
        $seoDesc = Setting::getVal('seo_home_description') ?: ($siteTitle . ' is a Christian devotional blog anchored in Scripture, sharing faith-building articles on spiritual growth, prayer, and living rooted in Jesus.');
        $seoKeywords = Setting::getVal('seo_home_keywords') ?: 'Christian devotional blog, Bible study, spiritual growth, faith, rooted in Christ, prayer, scripture, Jesus, devotional articles';

        // --- JSON-LD: Blog ---
        $blogJsonLd = json_encode([
            '@context'    => 'https://schema.org',
            '@type'       => 'Blog',
            '@id'         => url('/') . '/#blog',
            'name'        => $siteTitle . ' Blog',
            'url'         => url('/'),
            'description' => $seoDesc,
            'inLanguage'  => 'en-IN',
            'publisher'   => [
                '@type' => 'Organization',
                '@id'   => url('/') . '/#organization',
                'name'  => $siteTitle,
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $jsonLd = '<script type="application/ld+json">' . $blogJsonLd . '</script>';

        return view('livewire.home', compact('posts', 'categories', 'tags', 'activePost'))
            ->layout('components.layouts.app', [
                'title'          => $seoTitle,
                'description'    => $seoDesc,
                'keywords'       => $seoKeywords,
                'canonical'      => url('/'),
                'ogType'         => 'website',
                'ogTitle'        => $seoTitle,
                'ogDescription'  => $seoDesc,
                'jsonLd'         => $jsonLd,
            ]);
    }
}
