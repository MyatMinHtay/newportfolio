<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a published case study.
     */
    public function show(Project $project): View
    {
        if (! $project->is_published && ! auth()->user()?->is_admin) {
            abort(404);
        }

        $otherProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->ordered()
            ->take(3)
            ->get();

        return view('projects.show', compact('project', 'otherProjects'));
    }
}
