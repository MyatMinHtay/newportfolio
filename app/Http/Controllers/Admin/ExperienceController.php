<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExperienceRequest;
use App\Http\Requests\Admin\UpdateExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(): View
    {
        $experiences = Experience::query()
            ->ordered()
            ->paginate((int) project('pagination_size', 15));

        return view('admin.experiences.index', compact('experiences'));
    }

    public function create(): View
    {
        return view('admin.experiences.create');
    }

    public function store(StoreExperienceRequest $request): RedirectResponse
    {
        Experience::create($this->payload($request));

        return redirect()
            ->route('admin.experiences.index')
            ->with('toast_success', 'Experience saved.');
    }

    public function edit(Experience $experience): View
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(UpdateExperienceRequest $request, Experience $experience): RedirectResponse
    {
        $experience->update($this->payload($request));

        return redirect()
            ->route('admin.experiences.index')
            ->with('toast_success', 'Experience updated.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->delete();

        return redirect()
            ->route('admin.experiences.index')
            ->with('toast_success', 'Experience deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(StoreExperienceRequest|UpdateExperienceRequest $request): array
    {
        $data = $request->safe()->all();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
