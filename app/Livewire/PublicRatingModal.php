<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Testimonial;
use Illuminate\Support\Facades\RateLimiter;

class PublicRatingModal extends Component
{
    use WithFileUploads;

    public $isOpen = false;
    public $client_name = '';
    public $client_company = '';
    public $client_email = '';
    public $avatar = null;
    public $rating = 5;
    public $review = '';
    public $website_url = ''; // Honeypot field for bot trap

    public $successMessage = '';

    protected $listeners = ['openRatingModal' => 'openModal'];

    public function openModal()
    {
        $this->isOpen = true;
        $this->successMessage = '';
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['client_name', 'client_company', 'client_email', 'avatar', 'rating', 'review', 'website_url', 'successMessage']);
    }

    public function setRating($stars)
    {
        $this->rating = max(1, min(5, (int)$stars));
    }

    public function submitRating()
    {
        // Honeypot check: If bot filled website_url, silently ignore
        if (!empty($this->website_url)) {
            $this->closeModal();
            return;
        }

        $ip = request()->ip();
        $rateKey = 'submit-rating:' . $ip;

        // Rate Limiter: 1 submission per 10 minutes (600 seconds) per IP
        $executed = RateLimiter::attempt(
            $rateKey,
            1,
            function () use ($ip) {
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

                Testimonial::create([
                    'client_name' => strip_tags(trim($this->client_name)),
                    'client_company' => strip_tags(trim($this->client_company)),
                    'client_email' => strip_tags(trim($this->client_email)),
                    'avatar_path' => $avatarPath,
                    'rating' => (int) $this->rating,
                    'review' => strip_tags(trim($this->review)),
                    'status' => 'pending',
                    'is_featured' => false,
                    'ip_address' => $ip,
                ]);

                $this->successMessage = 'Terima kasih! Ulasan & rating Anda telah dikirim. Ulasan akan ditampilkan setelah diverifikasi oleh admin.';
            },
            600
        );

        if (!$executed) {
            $seconds = RateLimiter::availableIn($rateKey);
            $minutes = ceil($seconds / 60);
            $this->addError('rate_limit', "Mohon tunggu {$minutes} menit lagi sebelum mengirim ulasan baru.");
        }
    }

    public function render()
    {
        return view('livewire.public-rating-modal');
    }
}
