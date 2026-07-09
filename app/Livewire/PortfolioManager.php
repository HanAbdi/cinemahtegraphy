<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Storage;

class PortfolioManager extends Component
{
    public $portfolios;
    public $isConfirmDeleteOpen = false;
    public $delete_id;
    
    public $sortOption = 'year_asc_newest'; // Default

    public function mount()
    {
        $this->loadPortfolios();
    }

    public function updatedSortOption()
    {
        $this->loadPortfolios();
    }

    public function loadPortfolios()
    {
        $query = Portfolio::query();

        switch ($this->sortOption) {
            case 'year_asc_newest':
                $query->orderBy('year', 'asc')->orderBy('created_at', 'desc');
                break;
            case 'year_desc':
                $query->orderBy('year', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('year', 'asc')->orderBy('created_at', 'desc');
        }

        $this->portfolios = $query->get();
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
        $this->isConfirmDeleteOpen = true;
    }

    public function delete()
    {
        $portfolio = Portfolio::findOrFail($this->delete_id);
        if ($portfolio->image_path && Storage::disk('public')->exists($portfolio->image_path)) {
            Storage::disk('public')->delete($portfolio->image_path);
        }
        
        $title = $portfolio->title;
        $portfolio->delete();
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Portfolio',
            'model_id' => null,
            'description' => "Menghapus portofolio: {$title}",
        ]);

        $this->isConfirmDeleteOpen = false;
        $this->loadPortfolios();
    }

    public function render()
    {
        return view('livewire.portfolio-manager')->layout('components.admin-layout');
    }
}
