<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use Illuminate\Http\Request;

class CandidateProfileController extends Controller
{
   public function show()
    {
        $profile = auth()->user()->candidateProfile;

        return view('candidate-profile', compact('profile'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'about' => 'nullable|string|max:2000',
            'github' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'portfolio' => 'nullable|url|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

    if ($request->hasFile('profile_photo')) {
        $validated['profile_photo'] = $request
            ->file('profile_photo')
            ->store('profile-photos', 'public');
    }

        CandidateProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            $validated
        );

        return redirect('/candidate/profile')
            ->with('success', 'Profil bilgileriniz başarıyla kaydedildi.');
    }
}