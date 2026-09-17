<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Resume;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the renewed public portfolio homepage.
     */
    public function __invoke(Request $request): View
    {
        $projects = Project::published()
            ->ordered()
            ->get();

        $skills = Skill::published()
            ->ordered()
            ->get()
            ->groupBy('category');

        $services = Service::published()
            ->ordered()
            ->get();

        $experiences = Experience::published()
            ->ordered()
            ->get();

        $socialLinks = SocialLink::published()
            ->ordered()
            ->get();

        $activeResume = Resume::active()->first();

        // Key-value settings
        $settings = Setting::allCached();

        return view('welcome', compact(
            'projects',
            'skills',
            'services',
            'experiences',
            'socialLinks',
            'activeResume',
            'settings'
        ));
    }
}
