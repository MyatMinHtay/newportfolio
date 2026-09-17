<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::query()
            ->ordered()
            ->paginate((int) project('pagination_size', 15));

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        Service::create($this->payload($request));

        return redirect()
            ->route('admin.services.index')
            ->with('toast_success', 'Service saved.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $service->update($this->payload($request));

        return redirect()
            ->route('admin.services.index')
            ->with('toast_success', 'Service updated.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('toast_success', 'Service deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(StoreServiceRequest|UpdateServiceRequest $request): array
    {
        $data = $request->safe()->all();
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $icon = trim((string) ($data['icon'] ?? ''));
        $data['icon'] = $icon === '' ? 'bi-layers' : $icon;

        return $data;
    }
}
