<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\QuoteRequest;

class QuoteRequestManager extends Component
{
    public $quotes;
    public $viewingQuote = null;

    public function mount()
    {
        $this->loadQuotes();
    }

    public function loadQuotes()
    {
        $this->quotes = QuoteRequest::orderBy('created_at', 'desc')->get();
    }

    public function viewDetails($id)
    {
        $quote = QuoteRequest::findOrFail($id);
        if (!$quote->read_at) {
            $quote->update(['read_at' => now()]);
        }
        $this->viewingQuote = $quote;
        $this->loadQuotes();
    }

    public function closeDetails()
    {
        $this->viewingQuote = null;
    }

    public function updateStatus($id, $status)
    {
        $quote = QuoteRequest::findOrFail($id);
        $quote->update(['status' => $status]);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => 'QuoteRequest',
            'model_id' => $quote->id,
            'description' => "Memperbarui status penawaran dari {$quote->name} menjadi {$status}",
        ]);

        $this->loadQuotes();
        if ($this->viewingQuote && $this->viewingQuote->id == $id) {
            $this->viewingQuote->status = $status;
        }
    }



    public function toggleArchive($id)
    {
        $quote = QuoteRequest::findOrFail($id);
        $quote->update(['is_archived' => !$quote->is_archived]);
        $this->loadQuotes();
        if ($this->viewingQuote && $this->viewingQuote->id == $id) {
            $this->viewingQuote->is_archived = !$this->viewingQuote->is_archived;
        }
    }

    public function render()
    {
        return view('livewire.quote-request-manager')->layout('components.admin-layout');
    }
}
