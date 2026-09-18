<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSocialLinkRequest;
use App\Http\Requests\Admin\UpdateSocialLinkRequest;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
    public function index(): View
    {
        $socialLinks = SocialLink::query()
            ->ordered()
            ->paginate((int) project('pagination_size', 15));

        return view('admin.social_links.index', compact('socialLinks'));
    }

    public function create(): View
    {
        return view('admin.social_links.create');
    }

    public function store(StoreSocialLinkRequest $request): RedirectResponse
    {
        SocialLink::create($this->payload($request));

        return redirect()
            ->route('admin.social-links.index')
            ->with('toast_success', 'Social link saved.');
    }

    public function edit(SocialLink $socialLink): View
    {
        return view('admin.social_links.edit', compact('socialLink'));
    }

    public function update(UpdateSocialLinkRequest $request, SocialLink $socialLink): RedirectResponse
    {
        $socialLink->update($this->payload($request));

        return redirect()
            ->route('admin.social-links.index')
            ->with('toast_success', 'Social link updated.');
    }

    public function destroy(SocialLink $socialLink): RedirectResponse
    {
        $socialLink->delete();

        return redirect()
            ->route('admin.social-links.index')
            ->with('toast_success', 'Social link deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(StoreSocialLinkRequest|UpdateSocialLinkRequest $request): array
    {
        $data = $request->safe()->all();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $icon = trim((string) ($data['icon'] ?? ''));
        $data['icon'] = $icon === '' ? 'bi-link' : $icon;

        return $data;
    }
}
