<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreResumeRequest;
use App\Http\Requests\Admin\UpdateResumeRequest;
use App\Models\Resume;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ResumeController extends Controller
{
    public function index(): View
    {
        $resumes = Resume::query()
            ->orderByDesc('is_active')
            ->orderByDesc('id')
            ->paginate((int) project('pagination_size', 15));

        return view('admin.resumes.index', compact('resumes'));
    }

    public function create(): View
    {
        return view('admin.resumes.create');
    }

    public function store(StoreResumeRequest $request): RedirectResponse
    {
        $path = PublicUpload::storePdf($request->file('resume_file'), 'resumes');

        $resume = Resume::create([
            'title' => $request->input('title'),
            'file_path' => $path,
            'is_active' => false,
        ]);

        if ($request->boolean('is_active') || Resume::count() === 1) {
            $resume->activate();
        }

        return redirect()
            ->route('admin.resumes.index')
            ->with('toast_success', 'Resume uploaded.');
    }

    public function edit(Resume $resume): View
    {
        return view('admin.resumes.edit', compact('resume'));
    }

    public function update(UpdateResumeRequest $request, Resume $resume): RedirectResponse
    {
        $data = ['title' => $request->input('title')];

        if ($request->hasFile('resume_file')) {
            PublicUpload::delete($resume->file_path);
            $data['file_path'] = PublicUpload::storePdf($request->file('resume_file'), 'resumes');
        }

        $resume->update($data);

        if ($request->boolean('is_active')) {
            $resume->activate();
        }

        return redirect()
            ->route('admin.resumes.index')
            ->with('toast_success', 'Resume updated.');
    }

    public function activate(Resume $resume): RedirectResponse
    {
        $resume->activate();

        return redirect()
            ->route('admin.resumes.index')
            ->with('toast_success', 'Resume marked as active.');
    }

    public function destroy(Resume $resume): RedirectResponse
    {
        PublicUpload::delete($resume->file_path);
        $resume->delete();

        return redirect()
            ->route('admin.resumes.index')
            ->with('toast_success', 'Resume deleted.');
    }
}
