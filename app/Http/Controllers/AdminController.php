<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $userCount = User::count();

        $candidateCount = User::where('role', 'candidate')->count();

        $employerCount = User::where('role', 'employer')->count();

        $companyCount = Company::count();

        $publishedJobCount = Job::where('status', 'published')->count();

        $applicationCount = Application::count();

        return view('admin.dashboard', compact(
            'userCount',
            'candidateCount',
            'employerCount',
            'companyCount',
            'publishedJobCount',
            'applicationCount'
        ));
    }

    public function users()
    {
        $users = User::latest()->get();

        return view('admin.users', compact('users'));
    }

    public function companies()
    {
        $companies = Company::with('user')
            ->latest()
            ->get();

        return view('admin.companies', compact('companies'));
    }

    public function jobs()
    {
        $jobs = Job::with('company')
            ->latest()
            ->get();

        return view('admin.jobs', compact('jobs'));
    }

    public function applications()
    {
        $applications = Application::with([
            'user',
            'job.company',
            'cv'
        ])
        ->latest()
        ->get();

        return view('admin.applications', compact('applications'));
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'user' => 'Kendi admin hesabınızı silemezsiniz.'
            ]);
        }

        $user->delete();

        return redirect('/admin/users')
            ->with('success', 'Kullanıcı başarıyla silindi.');
    }

    public function toggleJobStatus(Job $job)
    {
        if ($job->status === 'published') {
            $job->update([
                'status' => 'closed',
            ]);

            $message = 'İlan yayından kaldırıldı.';
        } else {
            $job->update([
                'status' => 'published',
            ]);

            $message = 'İlan tekrar yayınlandı.';
        }

        return redirect('/admin/jobs')
            ->with('success', $message);
    }

    public function deleteJob(Job $job)
    {
        $job->delete();

        return redirect('/admin/jobs')
            ->with('success', 'İş ilanı silindi.');
    }

    public function showApplication(Application $application)
    {
        $application->load([
            'user',
            'user.candidateProfile',
            'user.educations',
            'user.experiences',
            'user.skills',
            'job.company',
            'cv',
        ]);

        return view(
            'admin.application-show',
            compact('application')
        );
    }
}