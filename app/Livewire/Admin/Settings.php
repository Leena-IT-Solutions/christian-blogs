<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
    use WithFileUploads;

    // Setting keys mapping
    public $site_subtitle = '';
    public $about_text = '';
    public $existing_about_image = '';
    public $about_image; // uploaded image file
    public $facebook_link = '';
    public $instagram_link = '';

    protected $rules = [
        'site_subtitle' => 'required|string|max:255',
        'about_text' => 'required|string',
        'about_image' => 'nullable|image|max:2048', // 2MB Max
        'facebook_link' => 'nullable|url',
        'instagram_link' => 'nullable|url',
    ];

    public function mount()
    {
        $this->site_subtitle = Setting::where('key', 'site_subtitle')->value('value') ?? 'Planted to Prevail & Produce';
        $this->about_text = Setting::where('key', 'about_text')->value('value') ?? 'Welcome to my blog. I write about spiritual growth, faith, and producing fruit in Christ.';
        $this->existing_about_image = Setting::where('key', 'about_image')->value('value') ?? '';
        $this->facebook_link = Setting::where('key', 'facebook_link')->value('value') ?? '';
        $this->instagram_link = Setting::where('key', 'instagram_link')->value('value') ?? '';
    }

    public function saveSettings()
    {
        $this->validate();

        // Save normal setting keys
        Setting::updateOrCreate(['key' => 'site_subtitle'], ['value' => $this->site_subtitle]);
        Setting::updateOrCreate(['key' => 'about_text'], ['value' => $this->about_text]);
        Setting::updateOrCreate(['key' => 'facebook_link'], ['value' => $this->facebook_link]);
        Setting::updateOrCreate(['key' => 'instagram_link'], ['value' => $this->instagram_link]);

        // Save image if uploaded
        if ($this->about_image) {
            // Delete old profile image if exists
            if ($this->existing_about_image) {
                $oldImagePath = public_path($this->existing_about_image);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }

            $filename = 'profile_' . time() . '.' . $this->about_image->getClientOriginalExtension();
            $path = $this->about_image->storeAs('uploads', $filename, 'public');
            $this->existing_about_image = 'storage/' . $path;
            
            Setting::updateOrCreate(['key' => 'about_image'], ['value' => $this->existing_about_image]);
            $this->reset('about_image');
        }

        session()->flash('message', 'Settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('components.layouts.admin')
            ->title('Settings - Kernel Admin');
    }
}
