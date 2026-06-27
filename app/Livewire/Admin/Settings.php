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
    public $site_title = '';
    public $site_subtitle = '';
    public $about_text = '';
    public $existing_about_image = '';
    public $about_image; // uploaded image file
    public $existing_site_logo = '';
    public $site_logo; // uploaded logo file
    public $existing_site_favicon = '';
    public $site_favicon; // uploaded favicon file
    public $use_logo_as_favicon = false; // toggle
    public $facebook_link = '';
    public $instagram_link = '';
    public $twitter_link = '';
    public $youtube_link = '';
    public $pinterest_link = '';
    public $theme_color = '#bf9f5a';

    // Homepage Hero properties
    public $hero_title = '';
    public $hero_subtitle = '';

    // Footer Quote properties
    public $footer_quote_text = '';
    public $footer_quote_author = '';

    protected $rules = [
        'site_title' => 'required|string|max:255',
        'site_subtitle' => 'required|string|max:255',
        'about_text' => 'required|string',
        'about_image' => 'nullable|image|max:2048', // 2MB Max
        'site_logo' => 'nullable|image|max:1024', // 1MB Max
        'site_favicon' => 'nullable|image|max:512', // 512KB Max
        'use_logo_as_favicon' => 'nullable|boolean',
        'facebook_link' => 'nullable|url',
        'instagram_link' => 'nullable|url',
        'twitter_link' => 'nullable|url',
        'youtube_link' => 'nullable|url',
        'pinterest_link' => 'nullable|url',
        'hero_title' => 'required|string|max:255',
        'hero_subtitle' => 'required|string|max:500',
        'theme_color' => 'required|string|regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
        'footer_quote_text' => 'nullable|string|max:500',
        'footer_quote_author' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $this->site_title = Setting::getVal('site_title', 'Be Rooted in Christ');
        $this->site_subtitle = Setting::getVal('site_subtitle', 'Planted to Prevail & Produce');
        $this->about_text = Setting::getVal('about_text', "Welcome to Be Rooted in Christ.\n\nThis blog is dedicated to sharing spiritual insights...");
        $this->existing_about_image = Setting::getVal('about_image');
        $this->existing_site_logo = Setting::getVal('site_logo');
        $this->existing_site_favicon = Setting::getVal('site_favicon');
        $this->use_logo_as_favicon = (bool) Setting::getVal('use_logo_as_favicon', '0');
        $this->facebook_link = Setting::getVal('facebook_link');
        $this->instagram_link = Setting::getVal('instagram_link');
        $this->twitter_link = Setting::getVal('twitter_link');
        $this->youtube_link = Setting::getVal('youtube_link');
        $this->pinterest_link = Setting::getVal('pinterest_link');
        $this->theme_color = Setting::getVal('theme_color', '#bf9f5a');

        // Load Homepage Hero keys
        $this->hero_title = Setting::getVal('hero_title', 'Planted to Prevail');
        $this->hero_subtitle = Setting::getVal('hero_subtitle', 'Sowing seeds of Truth, nurturing roots of faith, and bearing fruit for the glory of Christ.');

        // Load Footer Quote keys
        $this->footer_quote_text = Setting::getVal('footer_quote_text', 'As ye have therefore received Christ Jesus the Lord, so walk ye in him: Rooted and built up in him, and stablished in the faith...');
        $this->footer_quote_author = Setting::getVal('footer_quote_author', 'Colossians 2:6-7');
    }

    public function saveSettings()
    {
        $this->validate();

        // Save normal setting keys
        Setting::updateOrCreate(['key' => 'site_title'], ['value' => $this->site_title]);
        Setting::updateOrCreate(['key' => 'site_subtitle'], ['value' => $this->site_subtitle]);
        Setting::updateOrCreate(['key' => 'about_text'], ['value' => $this->about_text]);
        Setting::updateOrCreate(['key' => 'use_logo_as_favicon'], ['value' => $this->use_logo_as_favicon ? '1' : '0']);
        Setting::updateOrCreate(['key' => 'facebook_link'], ['value' => $this->facebook_link]);
        Setting::updateOrCreate(['key' => 'instagram_link'], ['value' => $this->instagram_link]);
        Setting::updateOrCreate(['key' => 'twitter_link'], ['value' => $this->twitter_link]);
        Setting::updateOrCreate(['key' => 'youtube_link'], ['value' => $this->youtube_link]);
        Setting::updateOrCreate(['key' => 'pinterest_link'], ['value' => $this->pinterest_link]);
        Setting::updateOrCreate(['key' => 'theme_color'], ['value' => $this->theme_color]);
        $this->updateCssThemeFiles($this->theme_color);

        // Save Homepage Hero keys
        Setting::updateOrCreate(['key' => 'hero_title'], ['value' => $this->hero_title]);
        Setting::updateOrCreate(['key' => 'hero_subtitle'], ['value' => $this->hero_subtitle]);

        // Save Footer Quote keys
        Setting::updateOrCreate(['key' => 'footer_quote_text'], ['value' => $this->footer_quote_text ?? '']);
        Setting::updateOrCreate(['key' => 'footer_quote_author'], ['value' => $this->footer_quote_author ?? '']);

        // Save site logo if uploaded
        if ($this->site_logo) {
            // Delete old logo if exists
            if ($this->existing_site_logo) {
                $oldLogoPath = public_path($this->existing_site_logo);
                if (file_exists($oldLogoPath)) {
                    @unlink($oldLogoPath);
                }
            }

            $filename = 'logo_' . time() . '.' . $this->site_logo->getClientOriginalExtension();
            $path = $this->site_logo->storeAs('uploads', $filename, 'public');
            $this->existing_site_logo = 'storage/' . $path;
            
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $this->existing_site_logo]);
            $this->reset('site_logo');
        }

        // Save site favicon if uploaded
        if ($this->site_favicon) {
            // Delete old favicon if exists
            if ($this->existing_site_favicon) {
                $oldFaviconPath = public_path($this->existing_site_favicon);
                if (file_exists($oldFaviconPath)) {
                    @unlink($oldFaviconPath);
                }
            }

            $filename = 'favicon_' . time() . '.' . $this->site_favicon->getClientOriginalExtension();
            $path = $this->site_favicon->storeAs('uploads', $filename, 'public');
            $this->existing_site_favicon = 'storage/' . $path;
            
            Setting::updateOrCreate(['key' => 'site_favicon'], ['value' => $this->existing_site_favicon]);
            $this->reset('site_favicon');
        }

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

    protected function updateCssThemeFiles($color)
    {
        // Sanitize hex color
        $color = trim($color);
        if (!preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
            return;
        }

        // Convert hex to rgb
        $hex = str_replace('#', '', $color);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        // Generate hover color
        $factor = ($r + $g + $b) / 3 > 128 ? 0.85 : 1.15; // light color -> darker hover, dark color -> lighter hover
        $hoverR = max(0, min(255, (int)($r * $factor)));
        $hoverG = max(0, min(255, (int)($g * $factor)));
        $hoverB = max(0, min(255, (int)($b * $factor)));
        $hoverHex = sprintf("#%02x%02x%02x", $hoverR, $hoverG, $hoverB);

        // Update public/css/app.css
        $appCssPath = public_path('css/app.css');
        if (file_exists($appCssPath)) {
            $appCssContent = file_get_contents($appCssPath);
            
            // Replace variables in :root
            $appCssContent = preg_replace('/--accent-color:\s*[^;]+;/', "--accent-color: {$color};", $appCssContent);
            $appCssContent = preg_replace('/--accent-hover:\s*[^;]+;/', "--accent-hover: {$hoverHex};", $appCssContent);
            $appCssContent = preg_replace('/--accent-light:\s*[^;]+;/', "--accent-light: rgba({$r}, {$g}, {$b}, 0.1);", $appCssContent);
            $appCssContent = preg_replace('/--glass-border:\s*[^;]+;/', "--glass-border: rgba({$r}, {$g}, {$b}, 0.2);", $appCssContent);
            
            file_put_contents($appCssPath, $appCssContent);
        }

        // Update public/css/admin.css
        $adminCssPath = public_path('css/admin.css');
        if (file_exists($adminCssPath)) {
            $adminCssContent = file_get_contents($adminCssPath);
            
            // Replace variables in :root
            $adminCssContent = preg_replace('/--accent-color:\s*[^;]+;/', "--accent-color: {$color};", $adminCssContent);
            $adminCssContent = preg_replace('/--accent-hover:\s*[^;]+;/', "--accent-hover: {$hoverHex};", $adminCssContent);
            $adminCssContent = preg_replace('/--accent-light:\s*[^;]+;/', "--accent-light: rgba({$r}, {$g}, {$b}, 0.15);", $adminCssContent);
            
            file_put_contents($adminCssPath, $adminCssContent);
        }
    }

    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('components.layouts.admin')
            ->title('Settings - Admin');
    }
}
