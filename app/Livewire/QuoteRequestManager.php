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
    public $convertTotalPrice = null;
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
        $this->convertTotalPrice = null;
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

        // Validate amount if provided
        $dp = $this->convertDpAmount ? str_replace(['Rp', '.', ',', ' '], '', $this->convertDpAmount) : 0;
        $total = $this->convertTotalPrice ? str_replace(['Rp', '.', ',', ' '], '', $this->convertTotalPrice) : null;
        
        $paymentStatus = 'pending';
        if (is_numeric($total) && is_numeric($dp) && $total > 0) {
            if ($dp >= $total) {
                $paymentStatus = 'paid';
            } elseif ($dp > 0) {
                $paymentStatus = 'partial';
            }
        } elseif (is_numeric($dp) && $dp > 0) {
            $paymentStatus = 'partial';
        }

        // Create a new Project linked to this quote
        $project = \App\Models\Project::create([
            'quote_request_id' => $quote->id,
            'title' => $quote->service_interested . ' - ' . $quote->name,
            'status' => 'Negotiation/DP',
            'event_date' => $this->convertEventDate,
            'dp_amount' => is_numeric($dp) ? $dp : 0,
            'total_price' => is_numeric($total) ? $total : null,
            'payment_status' => $paymentStatus,
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

    public $confirmingQuoteDeletion = false;
    public $quoteToDelete = null;

    public function confirmDeleteQuote($id)
    {
        $this->quoteToDelete = $id;
        $this->confirmingQuoteDeletion = true;
    }

    public function cancelDeleteQuote()
    {
        $this->confirmingQuoteDeletion = false;
        $this->quoteToDelete = null;
    }

    public function deleteQuote()
    {
        if (!$this->quoteToDelete) return;

        $quote = QuoteRequest::findOrFail($this->quoteToDelete);
        $quote->delete();
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'QuoteRequest',
            'model_id' => $this->quoteToDelete,
            'description' => "Menghapus penawaran dari {$quote->name}",
        ]);

        $this->loadQuotes();
        if ($this->viewingQuote && $this->viewingQuote->id == $this->quoteToDelete) {
            $this->viewingQuote = null;
        }

        $this->cancelDeleteQuote();
    }

    public function render()
    {
        return view('livewire.quote-request-manager')->layout('components.admin-layout');
    }
}
