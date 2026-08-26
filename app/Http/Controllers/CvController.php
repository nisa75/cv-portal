<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CvController extends Controller
{
    public function index()
    {
        $cvs = auth()->user()
            ->cvs()
            ->latest()
            ->get();

        return view('cvs.index', compact('cvs'));
    }

    public function create()
    {
        $user = auth()->user();

        if (!$user->isPremium() && $user->cvs()->count() >= 3) {
            return redirect('/candidate/cvs')
                ->with('error', 'Ücretsiz planda en fazla 3 CV oluşturabilirsiniz. Daha fazla CV için Premium üyeliğe geçebilirsiniz.');
        }

        return view('cvs.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isPremium() && $user->cvs()->count() >= 3) {
            return redirect('/candidate/cvs')
                ->with('error', 'Ücretsiz planda en fazla 3 CV oluşturabilirsiniz. Daha fazla CV için Premium üyeliğe geçebilirsiniz.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'template' => 'required|in:modern,classic,minimal',
        ]);

        $validated['public_token'] = Str::random(40);
        $validated['is_public'] = false;

        $user->cvs()->create($validated);

        return redirect('/candidate/cvs')
            ->with('success', 'CV başarıyla oluşturuldu.');
    }

    public function show(Cv $cv)
    {
        abort_unless($cv->user_id === auth()->id(), 403);

        $user = auth()->user();

        $profile = $user->candidateProfile;
        $educations = $user->educations()->latest()->get();
        $experiences = $user->experiences()->latest()->get();
        $skills = $user->skills()->latest()->get();

        return view('cvs.show', compact(
            'cv',
            'user',
            'profile',
            'educations',
            'experiences',
            'skills'
        ));
    }

    public function edit(Cv $cv)
    {
        abort_unless($cv->user_id === auth()->id(), 403);

        return view('cvs.edit', compact('cv'));
    }

    public function update(Request $request, Cv $cv)
    {
        abort_unless($cv->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'template' => 'required|in:modern,classic,minimal',
        ]);

        $cv->update($validated);

        return redirect('/candidate/cvs')
            ->with('success', 'CV başarıyla güncellendi.');
    }

    public function pdf(Cv $cv)
    {
        abort_unless($cv->user_id === auth()->id(), 403);

        $user = auth()->user();

        $profile = $user->candidateProfile;
        $educations = $user->educations()->latest()->get();
        $experiences = $user->experiences()->latest()->get();
        $skills = $user->skills()->latest()->get();

        $pdf = \PDF::loadView(
            'cvs.pdf',
            compact(
                'cv',
                'user',
                'profile',
                'educations',
                'experiences',
                'skills'
            )
        );

        $fileName = str_replace(' ', '-', $cv->title) . '.pdf';

        return $pdf->download($fileName);
    }

    public function togglePublic(Cv $cv)
    {
        abort_unless($cv->user_id === auth()->id(), 403);

        if (!$cv->public_token) {
            $cv->public_token = Str::random(40);
        }

        $cv->is_public = !$cv->is_public;

        $cv->save();

        return redirect('/candidate/cvs')
            ->with(
                'success',
                $cv->is_public
                    ? 'CV artık herkese açık.'
                    : 'CV artık gizli.'
            );
    }

    public function publicShow(string $token)
    {
        $cv = Cv::where('public_token', $token)
            ->where('is_public', true)
            ->firstOrFail();

        $user = $cv->user;

        $profile = $user->candidateProfile;
        $educations = $user->educations()->latest()->get();
        $experiences = $user->experiences()->latest()->get();
        $skills = $user->skills()->latest()->get();

        return view('cvs.public', compact(
            'cv',
            'user',
            'profile',
            'educations',
            'experiences',
            'skills'
        ));
    }

    public function destroy($id)
    {
        $cv = auth()->user()
            ->cvs()
            ->findOrFail($id);

        $cv->delete();

        return redirect('/candidate/cvs')
            ->with('success', 'CV silindi.');
    }
}