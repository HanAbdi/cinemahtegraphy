<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Testimonial;
use App\Models\ActivityLog;

class TestimonialManager extends Component
{
    use WithFileUploads;

    public $activeTab = 'pending'; // pending, approved, rejected, all

    // Form fields for admin creation/edit
    public $isFormOpen = false;
    public $testimonial_id = null;
    public $client_name = '';
    public $client_company = '';
    public $client_email = '';
    public $avatar = null;
    public $rating = 5;
    public $review = '';
    public $is_featured = false;

    // Delete confirmation
    public $isConfirmDeleteOpen = false;
    public $delete_id = null;

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function openForm()
    {
        $this->reset(['testimonial_id', 'client_name', 'client_company', 'client_email', 'avatar', 'rating', 'review', 'is_featured']);
        $this->rating = 5;
        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
    }

    public function saveTestimonial()
    {
        $this->validate([
            'client_name' => 'required|string|max:100',
            'client_company' => 'nullable|string|max:100',
            'client_email' => 'nullable|email|max:100',
            'avatar' => 'nullable|image|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        $avatarPath = null;
        if ($this->avatar) {
            $avatarPath = $this->avatar->store('testimonials', 'public');
        }

        $isNew = empty($this->testimonial_id);
        $dataToSave = [
            'client_name' => strip_tags(trim($this->client_name)),
            'client_company' => strip_tags(trim($this->client_company)),
            'client_email' => strip_tags(trim($this->client_email)),
            'rating' => (int) $this->rating,
            'review' => strip_tags(trim($this->review)),
            'status' => 'approved', // Admin entries default to approved
            'is_featured' => (bool) $this->is_featured,
        ];

        if ($avatarPath) {
            $dataToSave['avatar_path'] = $avatarPath;
        }

        $testimonial = Testimonial::updateOrCreate(
            ['id' => $this->testimonial_id],
            $dataToSave
        );

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $isNew ? 'created' : 'updated',
            'model_type' => 'Testimonial',
            'model_id' => $testimonial->id,
            'description' => ($isNew ? 'Menambahkan' : 'Memperbarui') . " ulasan dari: {$testimonial->client_name}",
        ]);

        $this->closeForm();
    }

    public function updateStatus($id, $status)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['status' => $status]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'Testimonial',
            'model_id' => $testimonial->id,
            'description' => "Mengubah status ulasan dari {$testimonial->client_name} menjadi '{$status}'",
        ]);
    }

    public function toggleFeatured($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_featured = !$testimonial->is_featured;
        $testimonial->save();

        $actionText = $testimonial->is_featured ? 'menandai sebagai unggulan' : 'melepas status unggulan';

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'Testimonial',
            'model_id' => $testimonial->id,
            'description' => "Berhasil {$actionText} ulasan dari {$testimonial->client_name}",
        ]);
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
        $this->isConfirmDeleteOpen = true;
    }

    public function delete()
    {
        $testimonial = Testimonial::findOrFail($this->delete_id);
        $name = $testimonial->client_name;
        $testimonial->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Testimonial',
            'model_id' => null,
            'description' => "Menghapus ulasan dari: {$name}",
        ]);

        $this->isConfirmDeleteOpen = false;
    }

    public function render()
    {
        $query = Testimonial::query();

        if ($this->activeTab !== 'all') {
            $query->where('status', $this->activeTab);
        }

        $testimonials = $query->orderBy('created_at', 'desc')->get();

        $pendingCount = Testimonial::where('status', 'pending')->count();
        $approvedCount = Testimonial::where('status', 'approved')->count();
        $rejectedCount = Testimonial::where('status', 'rejected')->count();

        return view('livewire.testimonial-manager', [
            'testimonials' => $testimonials,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
        ])->layout('components.admin-layout');
    }
}
