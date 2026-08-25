<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = auth()->user()->experiences()->latest()->get();

        return view('experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('experiences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'currently_working' => 'nullable|boolean',
            'description' => 'nullable|string|max:2000',
        ]);

        $validated['currently_working'] = $request->boolean('currently_working');

        if ($validated['currently_working']) {
            $validated['end_date'] = null;
        }

        auth()->user()->experiences()->create($validated);

        return redirect('/candidate/experiences')
            ->with('success', 'İş deneyimi başarıyla eklendi.');
    }

    public function edit(Experience $experience)
    {
        abort_unless($experience->user_id === auth()->id(), 403);

        return view('experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        abort_unless($experience->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'currently_working' => 'nullable|boolean',
            'description' => 'nullable|string|max:2000',
        ]);

        $validated['currently_working'] = $request->boolean('currently_working');

        if ($validated['currently_working']) {
            $validated['end_date'] = null;
        }

        $experience->update($validated);

        return redirect('/candidate/experiences')
            ->with('success', 'İş deneyimi güncellendi.');
    }

    public function destroy(Experience $experience)
    {
        abort_unless($experience->user_id === auth()->id(), 403);

        $experience->delete();

        return redirect('/candidate/experiences')
            ->with('success', 'İş deneyimi silindi.');
    }
}