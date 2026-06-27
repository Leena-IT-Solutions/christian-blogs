<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;

class About extends Component
{
    public $biography = '';
    public $profilePhoto = '';
    public $facebookLink = '';
    public $instagramLink = '';

    public function mount()
    {
        $this->biography     = Setting::where('key', 'about_text')->value('value') ?? 'Welcome to my blog. I write about spiritual growth, faith, and producing fruit in Christ.';
        $this->profilePhoto  = Setting::where('key', 'about_image')->value('value') ?? '';
        $this->facebookLink  = Setting::where('key', 'facebook_link')->value('value') ?? '';
        $this->instagramLink = Setting::where('key', 'instagram_link')->value('value') ?? '';
    }

    public function render()
    {
        $siteTitle = Setting::getVal('site_title', 'Be Rooted in Christ');
        $biography   = $this->biography;
        $description = \Str::limit(strip_tags($biography), 155);

        // --- JSON-LD: AboutPage ---
        $aboutJsonLd = json_encode([
            '@context'    => 'https://schema.org',
            '@type'       => 'AboutPage',
            '@id'         => url('/about'),
            'name'        => 'About the Author — ' . $siteTitle,
            'url'         => url('/about'),
            'description' => 'Learn about the author behind ' . $siteTitle . ', a devotional blog sharing faith-building articles grounded in Scripture.',
            'isPartOf'    => ['@type' => 'WebSite', '@id' => url('/') . '/#website'],
            'mainEntity'  => [
                '@type'       => 'Person',
                'name'        => $siteTitle . ' Author',
                'url'         => url('/about'),
                'description' => $description,
                'worksFor'    => ['@type' => 'Organization', 'name' => $siteTitle, 'url' => url('/')],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $jsonLd = '<script type="application/ld+json">' . $aboutJsonLd . '</script>';

        return view('livewire.about')
            ->layout('components.layouts.app', [
                'title'         => 'About the Author — ' . $siteTitle,
                'description'   => 'Learn about the author behind ' . $siteTitle . ', a devotional blog sharing faith-building articles grounded in Scripture and rooted in Jesus.',
                'keywords'      => 'about, Christian author, devotional blogger, ' . $siteTitle . ', faith, scripture',
                'canonical'     => url('/about'),
                'ogType'        => 'profile',
                'ogTitle'       => 'About the Author — ' . $siteTitle,
                'ogDescription' => 'Learn about the author behind ' . $siteTitle . ', a devotional blog sharing faith-building articles grounded in Scripture.',
                'jsonLd'        => $jsonLd,
            ]);
    }
}
