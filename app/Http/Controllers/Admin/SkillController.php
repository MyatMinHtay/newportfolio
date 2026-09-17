<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSkillRequest;
use App\Http\Requests\Admin\UpdateSkillRequest;
use App\Models\Skill;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        $skills = Skill::query()
            ->ordered()
            ->paginate((int) project('pagination_size', 15));

        return view('admin.skills.index', compact('skills'));
    }

    public function create(): View
    {
        return view('admin.skills.create');
    }

    public function store(StoreSkillRequest $request): RedirectResponse
    {
        Skill::create($this->payload($request));

        return redirect()
            ->route('admin.skills.index')
            ->with('toast_success', 'Skill saved.');
    }

    public function edit(Skill $skill): View
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(UpdateSkillRequest $request, Skill $skill): RedirectResponse
    {
        $payload = $this->payload($request);

        if (isset($payload['icon_path']) && $skill->icon_path && $payload['icon_path'] !== $skill->icon_path) {
            PublicUpload::delete($skill->icon_path);
        }

        $skill->update($payload);

        return redirect()
            ->route('admin.skills.index')
            ->with('toast_success', 'Skill updated.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        PublicUpload::delete($skill->icon_path);
        $skill->delete();

        return redirect()
            ->route('admin.skills.index')
            ->with('toast_success', 'Skill deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(StoreSkillRequest|UpdateSkillRequest $request): array
    {
        $data = $request->safe()->except(['icon']);

        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['proficiency'] = filled($data['proficiency'] ?? null) ? (int) $data['proficiency'] : null;

        if ($request->hasFile('icon')) {
            $data['icon_path'] = PublicUpload::storeImage($request->file('icon'), 'skills/icons');
        }

        return $data;
    }
}
