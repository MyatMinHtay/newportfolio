@php
    $groups = [
        'Main' => [
            ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'route' => 'admin.home'],
        ],
        'Portfolio' => [
            ['label' => 'Case Studies', 'icon' => 'bi-folder', 'route' => 'admin.projects.index', 'match' => 'admin.projects.*'],
            ['label' => 'Services', 'icon' => 'bi-briefcase', 'route' => 'admin.services.index', 'match' => 'admin.services.*'],
            ['label' => 'Skills', 'icon' => 'bi-stars', 'route' => 'admin.skills.index', 'match' => 'admin.skills.*'],
            ['label' => 'Experience', 'icon' => 'bi-clock-history', 'route' => 'admin.experiences.index', 'match' => 'admin.experiences.*'],
            ['label' => 'Resumes', 'icon' => 'bi-file-earmark-pdf', 'route' => 'admin.resumes.index', 'match' => 'admin.resumes.*'],
        ],
        'System' => [
            ['label' => 'Social Links', 'icon' => 'bi-share', 'route' => 'admin.social-links.index', 'match' => 'admin.social-links.*'],
            ['label' => 'Settings', 'icon' => 'bi-gear', 'route' => 'admin.settings.index', 'match' => 'admin.settings.*'],
        ],
        'Coming next' => [
            ['label' => 'Blog', 'icon' => 'bi-journal-text'],
            ['label' => 'Categories', 'icon' => 'bi-tags'],
            ['label' => 'Messages', 'icon' => 'bi-envelope'],
        ],
    ];
@endphp

<nav class="p-2" aria-label="Admin">
    @foreach ($groups as $group => $links)
        <div class="small text-uppercase text-muted px-2 mt-3 mb-1">{{ $group }}</div>
        <ul class="nav flex-column gap-1">
            @foreach ($links as $link)
                @php
                    $hasRoute = ! empty($link['route']);
                    $isActive = $hasRoute && request()->routeIs($link['match'] ?? $link['route']);
                @endphp
                <li class="nav-item">
                    @if ($hasRoute)
                        <a
                            href="{{ route($link['route']) }}"
                            @class(['nav-link rounded px-2 py-2', 'active' => $isActive, 'text-muted' => ! $isActive])
                        >
                            <i class="bi {{ $link['icon'] }} me-2" aria-hidden="true"></i>
                            {{ $link['label'] }}
                        </a>
                    @else
                        <span class="nav-link rounded px-2 py-2 text-muted">
                            <i class="bi {{ $link['icon'] }} me-2" aria-hidden="true"></i>
                            {{ $link['label'] }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ul>
    @endforeach
</nav>
