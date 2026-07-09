<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ClientLogo;
use Illuminate\Support\Facades\Storage;

class ClientLogoManager extends Component
{
    use WithFileUploads;

    public $name;
    public $uploadedLogo; // For upload

    public function render()
    {
        $logos = ClientLogo::orderBy('created_at', 'desc')->get();
        return view('livewire.client-logo-manager', compact('logos'))
            ->layout('components.admin-layout');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'uploadedLogo' => 'required|image|max:2048', // max 2MB
        ], [
            'uploadedLogo.required' => 'Silakan pilih file logo terlebih dahulu.',
            'uploadedLogo.image' => 'File harus berupa gambar.',
            'uploadedLogo.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $path = $this->uploadedLogo->store('client_logos', 'public');

        ClientLogo::create([
            'name' => $this->name,
            'logo_path' => $path,
        ]);

        $this->reset(['name', 'uploadedLogo']);
        session()->flash('message', 'Logo berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $logo = ClientLogo::findOrFail($id);
        
        if ($logo->logo_path) {
            Storage::disk('public')->delete($logo->logo_path);
        }
        
        $logo->delete();
        session()->flash('message', 'Logo berhasil dihapus.');
    }
}
