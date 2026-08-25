<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = auth()->user()->skills()->latest()->get();

        return view('skills.index', compact('skills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        auth()->user()->skills()->firstOrCreate($validated);

        return redirect('/candidate/skills')
            ->with('success', 'Yetenek eklendi.');
    }

    public function destroy(Skill $skill)
    {
        abort_unless($skill->user_id === auth()->id(), 403);

        $skill->delete();

        return redirect('/candidate/skills')
            ->with('success', 'Yetenek silindi.');
    }
}