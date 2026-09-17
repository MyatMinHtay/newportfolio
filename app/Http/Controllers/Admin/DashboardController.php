<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard summary.
     */
    public function index(): View
    {
        $stats = [
            'projects_count' => Project::count(),
            'skills_count' => Skill::count(),
            'services_count' => Service::count(),
            'experiences_count' => Experience::count(),
            'posts_count' => BlogPost::count(),
            'unread_messages_count' => ContactMessage::unread()->count(),
        ];

        $recentProjects = Project::ordered()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProjects'));
    }
}
