<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;

class ProjectKanban extends Component
{
    public $statuses = [
        'Negotiation/DP', 
        'Pre-Production', 
        'Production', 
        'Post-Production', 
        'Done'
    ];

    public $viewingProject = null;
    public $showProjectModal = false;
    
    public $editTotalPrice;
    public $editDpAmount;
    public $editPaymentStatus;

    public function viewProjectDetails($projectId)
    {
        $this->viewingProject = Project::with('quoteRequest')->findOrFail($projectId);
        $this->editTotalPrice = $this->viewingProject->total_price;
        $this->editDpAmount = $this->viewingProject->dp_amount;
        $this->editPaymentStatus = $this->viewingProject->payment_status;
        $this->showProjectModal = true;
    }

    public function savePaymentDetails()
    {
        if ($this->viewingProject) {
            // Calculate status based on amounts if not manually set correctly, or just trust the input
            $total = $this->editTotalPrice ?: null;
            $dp = $this->editDpAmount ?: 0;
            
            $this->viewingProject->update([
                'total_price' => $total,
                'dp_amount' => $dp,
                'payment_status' => $this->editPaymentStatus,
            ]);
            
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model_type' => 'Project',
                'model_id' => $this->viewingProject->id,
                'description' => "Memperbarui rincian pembayaran proyek '{$this->viewingProject->title}'",
            ]);
            
            // Reload project
            $this->viewingProject = Project::with('quoteRequest')->findOrFail($this->viewingProject->id);
        }
    }

    public function closeProjectDetails()
    {
        $this->showProjectModal = false;
        $this->viewingProject = null;
    }

    public function updateProjectStatus($projectId, $newStatus)
    {
        $project = Project::findOrFail($projectId);
        
        if (in_array($newStatus, $this->statuses) && $project->status !== $newStatus) {
            $oldStatus = $project->status;
            $project->update(['status' => $newStatus]);
            
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model_type' => 'Project',
                'model_id' => $project->id,
                'description' => "Memindahkan proyek '{$project->title}' dari {$oldStatus} ke tahap {$newStatus}",
            ]);
        }
    }

    public $confirmingProjectDeletion = false;
    public $projectToDelete = null;

    public function setEventDate($projectId, $date)
    {
        $project = Project::findOrFail($projectId);
        $project->update(['event_date' => $date]);
    }

    public function confirmDeleteProject($projectId)
    {
        $this->projectToDelete = $projectId;
        $this->confirmingProjectDeletion = true;
    }

    public function cancelDeleteProject()
    {
        $this->confirmingProjectDeletion = false;
        $this->projectToDelete = null;
    }

    public function deleteProject()
    {
        if (!$this->projectToDelete) return;
        
        $project = Project::findOrFail($this->projectToDelete);
        
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => 'Project',
            'model_id' => $project->id,
            'description' => "Menghapus proyek '{$project->title}'",
        ]);

        $project->delete();
        
        if ($this->viewingProject && $this->viewingProject->id == $this->projectToDelete) {
            $this->closeProjectDetails();
        }
        
        $this->cancelDeleteProject();
    }

    public function render()
    {
        // Get all projects, grouped by status
        $projects = Project::orderBy('created_at', 'desc')->get()->groupBy('status');
        
        return view('livewire.project-kanban', [
            'groupedProjects' => $projects
        ])->layout('components.admin-layout');
    }
}
