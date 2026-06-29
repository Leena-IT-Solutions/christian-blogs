<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class SeoSettings extends Component
{
    use WithFileUploads;

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

    // Social Share Image properties
    public $og_image;
    public $existing_og_image = '';

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
        'og_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // 5MB Max
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
        $this->existing_og_image = Setting::getVal('og_image');
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

        // Save OG image if uploaded
        if ($this->og_image) {
            // Delete old OG image if exists
            if ($this->existing_og_image) {
                $oldImagePath = public_path(str_replace('storage/', '', $this->existing_og_image));
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
                $oldImagePathSym = public_path($this->existing_og_image);
                if ($oldImagePathSym !== $oldImagePath && file_exists($oldImagePathSym)) {
                    @unlink($oldImagePathSym);
                }
            }

            $filename = 'og_default_' . time() . '.' . $this->og_image->getClientOriginalExtension();
            $targetPath = public_path('uploads/' . $filename);
            if (!file_exists(dirname($targetPath))) {
                @mkdir(dirname($targetPath), 0755, true);
            }
            if (!copy($this->og_image->getRealPath(), $targetPath)) {
                throw new \Exception("Could not copy uploaded sharing image to {$targetPath}. Please check folder permissions.");
            }
            $this->existing_og_image = 'uploads/' . $filename;
            
            Setting::updateOrCreate(['key' => 'og_image'], ['value' => $this->existing_og_image]);
            $this->reset('og_image');
        }

        session()->flash('message', 'SEO Configuration updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.seo-settings')
            ->layout('components.layouts.admin')
            ->title('SEO Settings - Admin');
    }
}

