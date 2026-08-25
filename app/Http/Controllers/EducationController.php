<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = auth()->user()->educations()->latest()->get();

        return view('educations.index', compact('educations'));
    }

    public function create()
    {
        return view('educations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'currently_studying' => 'nullable|boolean',
            'description' => 'nullable|string|max:2000',
        ]);

        $validated['currently_studying'] = $request->boolean('currently_studying');

        if ($validated['currently_studying']) {
            $validated['end_date'] = null;
        }

        auth()->user()->educations()->create($validated);

        return redirect('/candidate/educations')
            ->with('success', 'Eğitim bilgisi başarıyla eklendi.');
    }

    public function edit(Education $education)
    {
        abort_unless($education->user_id === auth()->id(), 403);

        return view('educations.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        abort_unless($education->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'currently_studying' => 'nullable|boolean',
            'description' => 'nullable|string|max:2000',
        ]);

        $validated['currently_studying'] = $request->boolean('currently_studying');

        if ($validated['currently_studying']) {
            $validated['end_date'] = null;
        }

        $education->update($validated);

        return redirect('/candidate/educations')
            ->with('success', 'Eğitim bilgisi güncellendi.');
    }

    public function destroy(Education $education)
    {
        abort_unless($education->user_id === auth()->id(), 403);

        $education->delete();

        return redirect('/candidate/educations')
            ->with('success', 'Eğitim bilgisi silindi.');
    }
}