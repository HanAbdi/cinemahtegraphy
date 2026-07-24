<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\QuoteRequest;

class QuoteRequestManager extends Component
{
    public $quotes;
    public $viewingQuote = null;
    
    // Modal State
    public $showConvertModal = false;
    public $convertingQuoteId = null;
    public $convertEventDate = null;
    public $convertDpAmount = null;

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

    public function confirmConvert($id)
    {
        $this->convertingQuoteId = $id;
        $this->convertEventDate = now()->addDays(7)->format('Y-m-d');
        $this->convertDpAmount = null;
        $this->showConvertModal = true;
    }

    public function cancelConvert()
    {
        $this->showConvertModal = false;
        $this->convertingQuoteId = null;
    }

    public function convertToProject()
    {
        $quote = QuoteRequest::findOrFail($this->convertingQuoteId);
        
        if ($quote->status !== 'approved') {
            return;
        }

        // Validate DP amount if provided
        $dp = $this->convertDpAmount ? str_replace(['Rp', '.', ',', ' '], '', $this->convertDpAmount) : 0;

        // Create a new Project linked to this quote
        $project = \App\Models\Project::create([
            'quote_request_id' => $quote->id,
            'title' => $quote->service_interested . ' - ' . $quote->name,
            'status' => 'Negotiation/DP',
            'event_date' => $this->convertEventDate,
            'dp_amount' => is_numeric($dp) ? $dp : 0,
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => 'Project',
            'model_id' => $project->id,
            'description' => "Penawaran dari {$quote->name} berhasil dikonversi menjadi Proyek dengan DP Rp " . number_format($project->dp_amount, 0, ',', '.'),
        ]);

        $this->showConvertModal = false;
        return redirect()->route('admin.projects.kanban')->with('success', 'Berhasil mengonversi penawaran menjadi proyek.');
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
