<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function index(): View
    {
        $members = TeamMember::ordered()->get();

        return view('admin.team-members.index', compact('members'));
    }

    public function create(): View
    {
        return view('admin.team-members.form', ['member' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMember($request);

        $validated['sort_order'] = (TeamMember::max('sort_order') ?? -1) + 1;
        $validated['is_visible'] = $request->boolean('is_visible', true);
        $validated['is_placeholder'] = $request->boolean('is_placeholder');

        TeamMember::create($validated);

        return redirect()->route('admin.team-members.index')->with('success', "\"{$validated['name']}\" added.");
    }

    public function edit(TeamMember $teamMember): View
    {
        return view('admin.team-members.form', ['member' => $teamMember]);
    }

    public function update(Request $request, TeamMember $teamMember): RedirectResponse
    {
        $validated = $this->validateMember($request);
        $validated['is_visible'] = $request->boolean('is_visible', true);
        $validated['is_placeholder'] = $request->boolean('is_placeholder');

        $teamMember->update($validated);

        return redirect()->route('admin.team-members.index')->with('success', "\"{$teamMember->name}\" updated.");
    }

    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        $teamMember->delete();

        return back()->with('success', 'Team member removed.');
    }

    public function toggle(TeamMember $teamMember): RedirectResponse
    {
        $teamMember->update(['is_visible' => ! $teamMember->is_visible]);

        return back()->with(
            'success',
            $teamMember->is_visible ? "\"{$teamMember->name}\" is now shown on the site." : "\"{$teamMember->name}\" is now hidden from the site."
        );
    }

    private function validateMember(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'photo_url' => ['nullable', 'url', 'max:2048'],
            'tags' => ['nullable', 'string', 'max:255'],
        ]);

        $tagsInput = $validated['tags'] ?? '';
        $validated['tags'] = $tagsInput === ''
            ? []
            : array_values(array_filter(array_map('trim', explode(',', $tagsInput))));

        return $validated;
    }
}
