<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Job;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()
            ->favorites()
            ->with('job.company')
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function store(Job $job)
    {
        abort_unless($job->status === 'published', 404);

        Favorite::firstOrCreate([
            'user_id' => auth()->id(),
            'job_post_id' => $job->id,
        ]);

        return back()->with('success', 'İlan favorilere eklendi.');
    }

    public function destroy(Job $job)
    {
        auth()->user()
            ->favorites()
            ->where('job_post_id', $job->id)
            ->delete();

        return back()->with('success', 'İlan favorilerden çıkarıldı.');
    }
}