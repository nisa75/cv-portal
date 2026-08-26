<?php

namespace App\Http\Controllers;

use App\Models\User;

class EmployerCandidateController extends Controller
{
    public function index()
    {
        $candidates = User::query()
            ->where('role', 'candidate')
            ->with([
                'candidateProfile',
                'skills',
                'educations',
                'experiences',
                'cvs',
            ])
            ->orderByDesc('is_featured')
            ->orderByDesc('featured_until')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view(
            'employer.candidates.index',
            compact('candidates')
        );
    }
}