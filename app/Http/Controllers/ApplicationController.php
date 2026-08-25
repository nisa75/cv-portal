<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use App\Notifications\ApplicationReceived;
use Illuminate\Http\Request;
use App\Notifications\NewApplicationReceived;

class ApplicationController extends Controller
{
    public function create(Job $job)
    {
        abort_unless($job->status === 'published', 404);

        $cvs = auth()->user()->cvs()->latest()->get();

        if ($cvs->isEmpty()) {
            return redirect('/candidate/cvs')
                ->withErrors([
                    'cv' => 'Başvuru yapabilmek için önce bir CV oluşturmalısınız.'
                ]);
        }

        $alreadyApplied = Application::where('user_id', auth()->id())
            ->where('job_post_id', $job->id)
            ->exists();

        if ($alreadyApplied) {
            return redirect('/candidate/jobs/' . $job->id)
                ->withErrors([
                    'application' => 'Bu ilana daha önce başvurdunuz.'
                ]);
        }

        return view('applications.create', compact('job', 'cvs'));
    }

    public function store(Request $request, Job $job)
    {
        abort_unless($job->status === 'published', 404);

        $validated = $request->validate([
            'cv_id' => 'required|integer|exists:cvs,id',
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        $cvBelongsToUser = auth()->user()
            ->cvs()
            ->where('id', $validated['cv_id'])
            ->exists();

        abort_unless($cvBelongsToUser, 403);

        $alreadyApplied = Application::where('user_id', auth()->id())
            ->where('job_post_id', $job->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->withErrors([
                'application' => 'Bu ilana daha önce başvurdunuz.'
            ]);
        }

        $application = Application::create([
            'user_id' => auth()->id(),
            'job_post_id' => $job->id,
            'cv_id' => $validated['cv_id'],
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'received',
        ]);

        auth()->user()->notify(
            new ApplicationReceived($application->load('job.company'))
        );
        $companyOwner = $job->company->user;

$companyOwner->notify(
    new NewApplicationReceived(
        $application->load('user', 'job')
    )
);

        return redirect('/candidate/applications')
            ->with('success', 'Başvurunuz başarıyla gönderildi.');
    }

    public function index()
    {
        $applications = auth()->user()
            ->applications()
            ->with(['job.company', 'cv'])
            ->latest()
            ->get();

        return view('applications.index', compact('applications'));
    }

    public function employerIndex()
    {
        $company = auth()->user()->company;

        if (!$company) {
            return redirect('/employer/company')
                ->withErrors([
                    'company' => 'Önce firma profilinizi oluşturmalısınız.'
                ]);
        }

        $applications = $company->jobs()
            ->with(['applications.user', 'applications.cv'])
            ->get()
            ->flatMap(function ($job) {
                return $job->applications->map(function ($application) use ($job) {
                    $application->job = $job;
                    return $application;
                });
            })
            ->sortByDesc('created_at')
            ->values();

        return view('applications.employer-index', compact('applications'));
    }

    public function employerShow(Application $application)
    {
        $job = $application->job()->with('company')->first();

        abort_unless(
            $job &&
            $job->company &&
            $job->company->user_id === auth()->id(),
            403
        );

        $application->load([
            'user.candidateProfile',
            'user.educations',
            'user.experiences',
            'user.skills',
            'cv',
        ]);

        return view('applications.employer-show', compact('application', 'job'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $job = $application->job()->with('company')->first();

        abort_unless(
            $job &&
            $job->company &&
            $job->company->user_id === auth()->id(),
            403
        );

        $validated = $request->validate([
            'status' => 'required|in:received,reviewing,pre_evaluation,technical_interview,hr_interview,offer,accepted,rejected',
        ]);

        $application->update([
            'status' => $validated['status'],
        ]);

        return redirect('/employer/applications/' . $application->id)
            ->with('success', 'Başvuru durumu güncellendi.');
    }
}