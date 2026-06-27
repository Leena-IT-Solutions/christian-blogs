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
        $biography   = $this->biography;
        $description = \Str::limit(strip_tags($biography), 155);

        // --- JSON-LD: AboutPage ---
        $aboutJsonLd = json_encode([
            '@context'    => 'https://schema.org',
            '@type'       => 'AboutPage',
            '@id'         => url('/about'),
            'name'        => 'About the Author — Be Rooted in Christ',
            'url'         => url('/about'),
            'description' => 'Learn about the author behind Be Rooted in Christ, a devotional blog sharing faith-building articles grounded in Scripture.',
            'isPartOf'    => ['@type' => 'WebSite', '@id' => 'https://berootedinchrist.com/#website'],
            'mainEntity'  => [
                '@type'       => 'Person',
                'name'        => 'Be Rooted in Christ Author',
                'url'         => url('/about'),
                'description' => $description,
                'worksFor'    => ['@type' => 'Organization', 'name' => 'Be Rooted in Christ', 'url' => 'https://berootedinchrist.com'],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $jsonLd = '<script type="application/ld+json">' . $aboutJsonLd . '</script>';

        return view('livewire.about')
            ->layout('components.layouts.app', [
                'title'         => 'About the Author — Be Rooted in Christ',
                'description'   => 'Learn about the author behind Be Rooted in Christ, a devotional blog sharing faith-building articles grounded in Scripture and rooted in Jesus.',
                'keywords'      => 'about, Christian author, devotional blogger, Be Rooted in Christ, faith, scripture',
                'canonical'     => url('/about'),
                'ogType'        => 'profile',
                'ogTitle'       => 'About the Author — Be Rooted in Christ',
                'ogDescription' => 'Learn about the author behind Be Rooted in Christ, a devotional blog sharing faith-building articles grounded in Scripture.',
                'jsonLd'        => $jsonLd,
            ]);
    }
}
