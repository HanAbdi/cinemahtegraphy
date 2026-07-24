<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CompanySetting;
use App\Models\ActivityLog;

class CompanySettingsManager extends Component
{
    public $office_address;
    public $email;
    public $phone;
    public $maps_iframe_url;
    public $instagram_url;
    public $youtube_url;

    public $successMessage = '';

    public function mount()
    {
        $settings = CompanySetting::getSettings();
        $this->office_address = $settings->office_address;
        $this->email = $settings->email;
        $this->phone = $settings->phone;
        $this->maps_iframe_url = $settings->maps_iframe_url;
        $this->instagram_url = $settings->instagram_url;
        $this->youtube_url = $settings->youtube_url;
    }

    public function saveSettings()
    {
        $this->validate([
            'office_address' => 'required|string|max:1000',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:100',
            'maps_iframe_url' => 'nullable|string|max:2000',
            'instagram_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
        ]);

        $settings = CompanySetting::getSettings();

        // Intelligent Extraction: If user pasted full <iframe src="..."> HTML code
        $cleanMapsUrl = $this->maps_iframe_url;
        if (preg_match('/src=["\']([^"\']+)["\']/', $this->maps_iframe_url, $matches)) {
            $cleanMapsUrl = $matches[1];
        }

        $settings->update([
            'office_address' => trim($this->office_address),
            'email' => trim($this->email),
            'phone' => trim($this->phone),
            'maps_iframe_url' => trim($cleanMapsUrl),
            'instagram_url' => trim($this->instagram_url),
            'youtube_url' => trim($this->youtube_url),
        ]);

        $this->maps_iframe_url = $cleanMapsUrl;

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'CompanySetting',
            'model_id' => $settings->id,
            'description' => 'Memperbarui informasi kantor dan kontak perusahaan',
            'ip_address' => request()->ip(),
        ]);

        $this->successMessage = 'Informasi Kantor & Kontak berhasil diperbarui!';
    }

    public function render()
    {
        return view('livewire.company-settings-manager')
            ->layout('components.admin-layout', ['title' => 'Informasi Kantor & Kontak']);
    }
}
