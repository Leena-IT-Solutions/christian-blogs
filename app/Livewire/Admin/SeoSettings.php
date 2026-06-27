<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class SeoSettings extends Component
{
    // SEO properties
    public $seo_home_title = '';
    public $seo_home_description = '';
    public $seo_home_keywords = '';
    public $seo_about_title = '';
    public $seo_about_description = '';
    public $seo_about_keywords = '';
    public $seo_contact_title = '';
    public $seo_contact_description = '';
    public $seo_contact_keywords = '';

    protected $rules = [
        'seo_home_title' => 'nullable|string|max:255',
        'seo_home_description' => 'nullable|string|max:500',
        'seo_home_keywords' => 'nullable|string|max:500',
        'seo_about_title' => 'nullable|string|max:255',
        'seo_about_description' => 'nullable|string|max:500',
        'seo_about_keywords' => 'nullable|string|max:500',
        'seo_contact_title' => 'nullable|string|max:255',
        'seo_contact_description' => 'nullable|string|max:500',
        'seo_contact_keywords' => 'nullable|string|max:500',
    ];

    public function mount()
    {
        // Load SEO keys
        $this->seo_home_title = Setting::getVal('seo_home_title');
        $this->seo_home_description = Setting::getVal('seo_home_description');
        $this->seo_home_keywords = Setting::getVal('seo_home_keywords');
        $this->seo_about_title = Setting::getVal('seo_about_title');
        $this->seo_about_description = Setting::getVal('seo_about_description');
        $this->seo_about_keywords = Setting::getVal('seo_about_keywords');
        $this->seo_contact_title = Setting::getVal('seo_contact_title');
        $this->seo_contact_description = Setting::getVal('seo_contact_description');
        $this->seo_contact_keywords = Setting::getVal('seo_contact_keywords');
    }

    public function saveSeo()
    {
        $this->validate();

        // Save SEO setting keys
        Setting::updateOrCreate(['key' => 'seo_home_title'], ['value' => $this->seo_home_title ?? '']);
        Setting::updateOrCreate(['key' => 'seo_home_description'], ['value' => $this->seo_home_description ?? '']);
        Setting::updateOrCreate(['key' => 'seo_home_keywords'], ['value' => $this->seo_home_keywords ?? '']);
        Setting::updateOrCreate(['key' => 'seo_about_title'], ['value' => $this->seo_about_title ?? '']);
        Setting::updateOrCreate(['key' => 'seo_about_description'], ['value' => $this->seo_about_description ?? '']);
        Setting::updateOrCreate(['key' => 'seo_about_keywords'], ['value' => $this->seo_about_keywords ?? '']);
        Setting::updateOrCreate(['key' => 'seo_contact_title'], ['value' => $this->seo_contact_title ?? '']);
        Setting::updateOrCreate(['key' => 'seo_contact_description'], ['value' => $this->seo_contact_description ?? '']);
        Setting::updateOrCreate(['key' => 'seo_contact_keywords'], ['value' => $this->seo_contact_keywords ?? '']);

        session()->flash('message', 'SEO Configuration updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.seo-settings')
            ->layout('components.layouts.admin')
            ->title('SEO Settings - Admin');
    }
}
