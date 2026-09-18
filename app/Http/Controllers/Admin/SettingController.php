<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::allCached();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        foreach ($request->validated() as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('toast_success', 'Settings updated.');
    }
}
