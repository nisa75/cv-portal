<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // =========================
    // EMPLOYER
    // =========================

    public function employerIndex()
    {
        $company = auth()->user()->company;

        if (!$company) {
            return redirect('/employer/company')
                ->withErrors([
                    'company' => 'Önce firma profilinizi oluşturmalısınız.'
                ]);
        }

        $jobs = $company->jobs()->latest()->get();

        return view('jobs.employer-index', compact('company', 'jobs'));
    }

    public function create()
    {
        if (!auth()->user()->company) {
            return redirect('/employer/company')
                ->withErrors([
                    'company' => 'Önce firma profilinizi oluşturmalısınız.'
                ]);
        }

        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $company = auth()->user()->company;

        if (!$company) {
            return redirect('/employer/company')
                ->withErrors([
                    'company' => 'Önce firma profilinizi oluşturmalısınız.'
                ]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'employment_type' => 'required|string|max:100',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0|max:99999999.99',
            'salary_max' => 'nullable|numeric|min:0|max:99999999.99|gte:salary_min',
            'experience_level' => 'nullable|string|max:100',
            'education_level' => 'nullable|string|max:100',
            'description' => 'required|string|max:10000',
            'skills' => 'nullable|string|max:2000',
            'benefits' => 'nullable|string|max:3000',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        $validated['status'] = 'published';

        $company->jobs()->create($validated);

        return redirect('/employer/jobs')
            ->with('success', 'İş ilanı başarıyla yayınlandı.');
    }

    public function edit(Job $job)
    {
        $this->checkOwnership($job);

        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $this->checkOwnership($job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'employment_type' => 'required|string|max:100',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0|max:99999999.99',
            'salary_max' => 'nullable|numeric|min:0|max:99999999.99|gte:salary_min',
            'experience_level' => 'nullable|string|max:100',
            'education_level' => 'nullable|string|max:100',
            'description' => 'required|string|max:10000',
            'skills' => 'nullable|string|max:2000',
            'benefits' => 'nullable|string|max:3000',
            'deadline' => 'nullable|date|after_or_equal:today',
            'status' => 'required|in:published,draft,closed',
        ]);

        $job->update($validated);

        return redirect('/employer/jobs')
            ->with('success', 'İş ilanı güncellendi.');
    }

    public function destroy(Job $job)
    {
        $this->checkOwnership($job);

        $job->delete();

        return redirect('/employer/jobs')
            ->with('success', 'İş ilanı silindi.');
    }


    // =========================
    // CANDIDATE
    // =========================

    public function index(Request $request)
    {
        $query = Job::with('company')
            ->where('status', 'published');

        // Anahtar kelime
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('skills', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            });
        }

        // Şehir
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Çalışma şekli
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        // Deneyim
        if ($request->filled('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }

        // Minimum maaş
        if ($request->filled('salary_min')) {
            $query->where('salary_max', '>=', $request->salary_min);
        }

        $jobs = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        abort_unless($job->status === 'published', 404);

        $job->load('company');

        return view('jobs.show', compact('job'));
    }


    // =========================
    // OWNERSHIP
    // =========================

    private function checkOwnership(Job $job): void
    {
        abort_unless(
            $job->company &&
            $job->company->user_id === auth()->id(),
            403
        );
    }
}