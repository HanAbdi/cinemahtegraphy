<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Project $project)
    {
        $project->load('quoteRequest');
        $settings = CompanySetting::first();
        
        return view('pages.admin.invoice', compact('project', 'settings'));
    }
}
