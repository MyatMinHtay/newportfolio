<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $query = Project::query();

        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'hidden') {
            $query->where('is_published', false);
        } elseif ($status === 'featured') {
            $query->where('is_featured', true);
        }

        $projects = $query
            ->ordered()
            ->paginate((int) project('pagination_size', 15))
            ->withQueryString();

        $counts = [
            'all' => Project::count(),
            'published' => Project::where('is_published', true)->count(),
            'hidden' => Project::where('is_published', false)->count(),
            'featured' => Project::where('is_featured', true)->count(),
        ];

        return view('admin.projects.index', compact('projects', 'status', 'counts'));
    }

    public function togglePublish(Project $project): RedirectResponse
    {
        $project->update(['is_published' => ! $project->is_published]);

        $statusText = $project->is_published ? 'published' : 'hidden';

        return back()->with('toast_success', "Case study is now {$statusText}.");
    }

    public function toggleFeatured(Project $project): RedirectResponse
    {
        $project->update(['is_featured' => ! $project->is_featured]);

        $statusText = $project->is_featured ? 'featured' : 'unfeatured';

        return back()->with('toast_success', "Case study is now {$statusText}.");
    }

    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $project = Project::create($this->payload($request));

        return redirect()
            ->route('admin.projects.edit', $project)
            ->with('toast_success', 'Case study saved.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $payload = $this->payload($request, $project);

        if (isset($payload['cover_image']) && $project->cover_image && $payload['cover_image'] !== $project->cover_image) {
            PublicUpload::delete($project->cover_image);
        }

        $project->update($payload);

        return redirect()
            ->route('admin.projects.edit', $project->fresh())
            ->with('toast_success', 'Case study updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        PublicUpload::delete($project->cover_image);

        if ($project->gallery && is_array($project->gallery)) {
            foreach ($project->gallery as $path) {
                if (is_string($path)) {
                    PublicUpload::delete($path);
                }
            }
        }

        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('toast_success', 'Case study deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(StoreProjectRequest|UpdateProjectRequest $request, ?Project $project = null): array
    {
        $data = $request->safe()->except(['cover_image', 'gallery_images', 'remove_gallery', 'tech_stack']);

        $data['tech_stack'] = $this->parseTechStack($request->input('tech_stack'));
        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        foreach (['started_at', 'ended_at'] as $dateField) {
            if (! filled($data[$dateField] ?? null)) {
                $data[$dateField] = null;
            }
        }
        $data['slug'] = $this->uniqueSlug(
            filled($data['slug'] ?? null) ? (string) $data['slug'] : (string) $data['title'],
            $project?->id
        );

        if ($request->hasFile('cover_image')) {
            if ($project?->cover_image) {
                PublicUpload::delete($project->cover_image);
            }
            $data['cover_image'] = PublicUpload::storeImage($request->file('cover_image'), 'projects/covers');
        }

        $gallery = $project?->gallery ?? [];
        if (! is_array($gallery)) {
            $gallery = [];
        }

        // Deletion safety: Only delete files that strictly exist in the project's current gallery
        if ($request->filled('remove_gallery')) {
            $removePaths = (array) $request->input('remove_gallery');
            foreach ($removePaths as $pathToRemove) {
                if (is_string($pathToRemove) && in_array($pathToRemove, $gallery, true)) {
                    PublicUpload::delete($pathToRemove);
                    $gallery = array_values(array_filter($gallery, fn ($p) => $p !== $pathToRemove));
                }
            }
        }

        // Handle newly uploaded gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file && $file->isValid()) {
                    $gallery[] = PublicUpload::storeImage($file, 'projects/gallery');
                }
            }
        }

        $data['gallery'] = array_values($gallery);

        return $data;
    }

    /**
     * @return list<string>|null
     */
    private function parseTechStack(?string $value): ?array
    {
        if (! filled($value)) {
            return null;
        }

        $items = collect(preg_split('/[\n,]+/', $value) ?: [])
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();

        return $items === [] ? null : $items;
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source) ?: 'project';
        $slug = $base;
        $i = 2;

        while (
            Project::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
