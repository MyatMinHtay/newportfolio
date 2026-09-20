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
            'published_projects_count' => Project::where('is_published', true)->count(),
            'featured_projects_count' => Project::where('is_featured', true)->count(),
            'skills_count' => Skill::count(),
            'services_count' => Service::count(),
            'experiences_count' => Experience::count(),
            'resumes_count' => \App\Models\Resume::count(),
            'social_links_count' => \App\Models\SocialLink::count(),
            'posts_count' => BlogPost::count(),
            'published_posts_count' => BlogPost::where('is_published', true)->count(),
            'draft_posts_count' => BlogPost::where('is_published', false)->count(),
            'unread_messages_count' => ContactMessage::unread()->count(),
        ];

        $activeResume = \App\Models\Resume::where('is_active', true)->first();
        $recentProjects = Project::ordered()->take(5)->get();
        $recentPosts = BlogPost::with('category')->orderByDesc('id')->take(5)->get();
        $recentMessages = ContactMessage::orderByDesc('id')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'activeResume', 'recentProjects', 'recentPosts', 'recentMessages'));
    }
}
