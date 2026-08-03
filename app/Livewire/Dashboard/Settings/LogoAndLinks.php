<?php

namespace App\Livewire\Dashboard\Settings;
use App\Models\WebsiteSetting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LogoAndLinks extends Component
{
     use WithFileUploads;

    public $websiteSettings;
    public $activeTab = 'general';
    
    // Logo temporary files
    public $logo_light_temp;
    public $logo_dark_temp;
    public $favicon_temp;
    public $og_image_temp;
    
    // Validation rules
    protected function rules()
    {
        return [
            'websiteSettings.website_name' => 'required|string|max:255',
            'websiteSettings.website_tagline' => 'nullable|string|max:255',
            'websiteSettings.website_description' => 'nullable|string',
            'websiteSettings.logo_alt_text' => 'nullable|string|max:255',
            'websiteSettings.email' => 'nullable|email|max:255',
            'websiteSettings.phone' => 'nullable|string|max:255',
            'websiteSettings.whatsapp' => 'nullable|string|max:255',
            'websiteSettings.address' => 'nullable|string|max:500',
            'websiteSettings.location_url' => 'nullable|url|max:500',
            'websiteSettings.facebook' => 'nullable|url|max:255',
            'websiteSettings.twitter' => 'nullable|url|max:255',
            'websiteSettings.instagram' => 'nullable|url|max:255',
            'websiteSettings.youtube' => 'nullable|url|max:255',
            'websiteSettings.linkedin' => 'nullable|url|max:255',
            'websiteSettings.pinterest' => 'nullable|url|max:255',
            'websiteSettings.tiktok' => 'nullable|url|max:255',
            'websiteSettings.github' => 'nullable|url|max:255',
            'websiteSettings.meta_title' => 'nullable|string|max:255',
            'websiteSettings.meta_description' => 'nullable|string|max:500',
            'websiteSettings.meta_keywords' => 'nullable|string|max:500',
            'websiteSettings.primary_color' => 'nullable|string|max:50',
            'websiteSettings.secondary_color' => 'nullable|string|max:50',
            'websiteSettings.dark_mode' => 'required|in:auto,light,dark',
            'websiteSettings.footer_text' => 'nullable|string|max:255',
            'websiteSettings.copyright_text' => 'nullable|string|max:255',
            'websiteSettings.show_powered_by' => 'boolean',
            'websiteSettings.google_analytics' => 'nullable|string',
            'websiteSettings.custom_css' => 'nullable|string',
            'websiteSettings.custom_js' => 'nullable|string',
            'websiteSettings.head_scripts' => 'nullable|string',
            'websiteSettings.body_scripts' => 'nullable|string',
            'websiteSettings.is_maintenance' => 'boolean',
            'websiteSettings.maintenance_message' => 'nullable|string|max:500',
            'websiteSettings.allow_registration' => 'boolean',
        ];
    }

    protected $messages = [
        'websiteSettings.website_name.required' => 'Website name is required',
        'websiteSettings.email.email' => 'Please enter a valid email address',
        'websiteSettings.facebook.url' => 'Please enter a valid Facebook URL',
        'websiteSettings.twitter.url' => 'Please enter a valid Twitter URL',
        'websiteSettings.instagram.url' => 'Please enter a valid Instagram URL',
        'websiteSettings.youtube.url' => 'Please enter a valid YouTube URL',
        'websiteSettings.linkedin.url' => 'Please enter a valid LinkedIn URL',
        'websiteSettings.pinterest.url' => 'Please enter a valid Pinterest URL',
        'websiteSettings.tiktok.url' => 'Please enter a valid TikTok URL',
        'websiteSettings.github.url' => 'Please enter a valid GitHub URL',
        'websiteSettings.location_url.url' => 'Please enter a valid location URL',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $settings = WebsiteSetting::getSettings();
        $this->websiteSettings = $settings->toArray();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetValidation();
    }

    public function saveSettings()
    {
        $this->validate();

        try {
            $settings = WebsiteSetting::first();
            if (!$settings) {
                $settings = new WebsiteSetting();
            }

            // Prepare data for update
            $data = $this->websiteSettings;

            // Handle logo uploads
            if ($this->logo_light_temp) {
                $path = $this->logo_light_temp->store('logos', 'public');
                $data['logo_light'] = $path;
                // Delete old logo if exists
                if ($settings->logo_light && !filter_var($settings->logo_light, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($settings->logo_light);
                }
            }

            if ($this->logo_dark_temp) {
                $path = $this->logo_dark_temp->store('logos', 'public');
                $data['logo_dark'] = $path;
                if ($settings->logo_dark && !filter_var($settings->logo_dark, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($settings->logo_dark);
                }
            }

            if ($this->favicon_temp) {
                $path = $this->favicon_temp->store('favicons', 'public');
                $data['favicon'] = $path;
                if ($settings->favicon && !filter_var($settings->favicon, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($settings->favicon);
                }
            }

            if ($this->og_image_temp) {
                $path = $this->og_image_temp->store('og-images', 'public');
                $data['og_image'] = $path;
                if ($settings->og_image && !filter_var($settings->og_image, FILTER_VALIDATE_URL)) {
                    Storage::disk('public')->delete($settings->og_image);
                }
            }

            // Remove temporary keys from data
            unset($data['logo_light_url']);
            unset($data['logo_dark_url']);
            unset($data['favicon_url']);
            unset($data['og_image_url']);
            unset($data['social_links']);
            unset($data['active_social_links']);
            unset($data['meta_tags']);
            unset($data['contact_info']);

            $settings->fill($data);
            $settings->save();

            // Clear temporary files
            $this->logo_light_temp = null;
            $this->logo_dark_temp = null;
            $this->favicon_temp = null;
            $this->og_image_temp = null;

            $this->loadSettings(); // Reload to get updated values

            $this->dispatch('notification', [
                'message' => 'Website settings saved successfully!',
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            Log::error('Error saving website settings: ' . $e->getMessage());
            $this->dispatch('notification', [
                'message' => 'Error saving settings. Please try again.',
                'type' => 'error'
            ]);
        }
    }

    public function removeLogo($type)
    {
        $settings = WebsiteSetting::first();
        if ($settings) {
            $field = $type . '_temp';
            $dbField = $type;
            
            if ($settings->$dbField && !filter_var($settings->$dbField, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($settings->$dbField);
            }
            
            $settings->$dbField = null;
            $settings->save();
            
            $this->loadSettings();
            
            $this->dispatch('notification', [
                'message' => ucfirst($type) . ' removed successfully!',
                'type' => 'success'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.settings.logo-and-links')->extends('layouts.admin')
            ->section('admin-content');
    }
}
