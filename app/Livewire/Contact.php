<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\Setting;
use Livewire\Component;

class Contact extends Component
{
    // Form fields
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';

    // Success State
    public $showSuccessModal = false;

    protected $rules = [
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'subject' => 'nullable|string|max:255',
        'message' => 'required|string|min:10|max:5000',
    ];

    public function submitForm()
    {
        $this->validate();

        Message::create([
            'name'    => $this->name,
            'email'   => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        $this->reset(['name', 'email', 'subject', 'message']);
        $this->showSuccessModal = true;
    }

    public function closeSuccessModal()
    {
        $this->showSuccessModal = false;
    }

    public function render()
    {
        $siteTitle = Setting::getVal('site_title', 'Be Rooted in Christ');

        // --- JSON-LD: ContactPage ---
        $contactJsonLd = json_encode([
            '@context'    => 'https://schema.org',
            '@type'       => 'ContactPage',
            '@id'         => url('/contact'),
            'name'        => 'Contact — ' . $siteTitle,
            'url'         => url('/contact'),
            'description' => 'Send a message, share a prayer request, or get in touch with ' . $siteTitle . '.',
            'isPartOf'    => ['@type' => 'WebSite', '@id' => url('/') . '/#website'],
            'mainEntity'  => [
                '@type'        => 'Organization',
                '@id'          => url('/') . '/#organization',
                'name'         => $siteTitle,
                'url'          => url('/'),
                'email'        => 'leenaitsolutions@gmail.com',
                'contactPoint' => [
                    '@type'             => 'ContactPoint',
                    'contactType'       => 'customer support',
                    'email'             => 'leenaitsolutions@gmail.com',
                    'availableLanguage' => 'English',
                ],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $jsonLd = '<script type="application/ld+json">' . $contactJsonLd . '</script>';

        return view('livewire.contact')
            ->layout('components.layouts.app', [
                'title'         => 'Contact — ' . $siteTitle,
                'description'   => 'Have a question, prayer request, or feedback? Get in touch with ' . $siteTitle . '.',
                'keywords'      => 'contact, prayer request, get in touch, ' . $siteTitle . ', Christian blog',
                'canonical'     => url('/contact'),
                'ogType'        => 'website',
                'ogTitle'       => 'Contact — ' . $siteTitle,
                'ogDescription' => 'Send a message, share a prayer request, or get in touch with ' . $siteTitle . '.',
                'robots'        => 'noindex, follow',
                'twitterCard'   => 'summary',
                'jsonLd'        => $jsonLd,
            ]);
    }
}
