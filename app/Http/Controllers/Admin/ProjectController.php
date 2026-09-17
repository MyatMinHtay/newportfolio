<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()
            ->ordered()
            ->paginate((int) project('pagination_size', 15));

        return view('admin.projects.index', compact('projects'));
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
        $data = $request->safe()->except(['cover_image', 'tech_stack']);

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
            $data['cover_image'] = PublicUpload::storeImage($request->file('cover_image'), 'projects/covers');
        }

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
