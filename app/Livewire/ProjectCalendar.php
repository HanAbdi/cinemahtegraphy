<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;

class ProjectCalendar extends Component
{
    public function getEventsProperty()
    {
        $projects = Project::whereNotNull('event_date')->get();
        
        $events = [];
        
        foreach ($projects as $project) {
            $events[] = [
                'id' => $project->id,
                'title' => $project->title,
                'start' => $project->event_date->format('Y-m-d'),
                'extendedProps' => [
                    'status' => $project->status,
                    'dp' => $project->dp_amount,
                ],
                'className' => $this->getStatusColor($project->status)
            ];
        }
        
        return json_encode($events);
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'Negotiation/DP' => 'bg-amber-500 border-amber-600 text-black font-bold',
            'Pre-Production' => 'bg-blue-500 border-blue-600 text-white font-bold',
            'Production' => 'bg-purple-500 border-purple-600 text-white font-bold',
            'Post-Production' => 'bg-pink-500 border-pink-600 text-white font-bold',
            'Done' => 'bg-green-500 border-green-600 text-white font-bold',
            default => 'bg-gray-500 border-gray-600 text-white font-bold',
        };
    }

    public function render()
    {
        return view('livewire.project-calendar')->layout('components.admin-layout');
    }
}
