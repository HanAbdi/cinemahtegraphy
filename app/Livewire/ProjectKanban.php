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

    public function setEventDate($projectId, $date)
    {
        $project = Project::findOrFail($projectId);
        $project->update(['event_date' => $date]);
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
