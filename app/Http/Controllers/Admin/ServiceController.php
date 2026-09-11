<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::ordered()->get();

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.form', ['service' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateService($request);

        $validated['sort_order'] = (Service::max('sort_order') ?? -1) + 1;
        $validated['is_visible'] = $request->boolean('is_visible', true);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', "Service \"{$validated['title']}\" added.");
    }

    public function edit(Service $service): View
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $this->validateService($request);
        $validated['is_visible'] = $request->boolean('is_visible', true);

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', "Service \"{$service->title}\" updated.");
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return back()->with('success', 'Service removed.');
    }

    public function toggle(Service $service): RedirectResponse
    {
        $service->update(['is_visible' => ! $service->is_visible]);

        return back()->with(
            'success',
            $service->is_visible ? "\"{$service->title}\" is now shown on the site." : "\"{$service->title}\" is now hidden from the site."
        );
    }

    private function validateService(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['icon'] = $validated['icon'] ?: 'heart-handshake';

        return $validated;
    }
}
