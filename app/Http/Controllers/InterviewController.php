<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function create(Application $application)
    {
        $this->checkEmployerAccess($application);

        return view('interviews.create', compact('application'));
    }

    public function store(Request $request, Application $application)
    {
        $this->checkEmployerAccess($application);

        $validated = $request->validate([
            'type' => 'required|in:online,office,phone',
            'scheduled_at' => 'required|date|after:now',
            'duration' => 'required|integer|min:15|max:240',
            'location' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|url|max:500',
            'notes' => 'nullable|string|max:5000',
        ]);

        $validated['application_id'] = $application->id;
        $validated['created_by'] = auth()->id();
        $validated['status'] = 'pending';

        Interview::updateOrCreate(
            [
                'application_id' => $application->id,
            ],
            $validated
        );

        $application->user->notify(
            new \App\Notifications\InterviewScheduled(
                Interview::where('application_id', $application->id)->first()
            )
        );

        return redirect('/employer/applications/' . $application->id)
            ->with('success', 'Mülakat başarıyla planlandı.');
    }

    public function candidateIndex()
    {
        $interviews = auth()->user()
            ->applications()
            ->with([
                'job.company',
                'interview.creator',
            ])
            ->whereHas('interview')
            ->latest()
            ->get();

        return view('interviews.index', compact('interviews'));
    }

    public function respond(Request $request, Interview $interview)
    {
        abort_unless(
            $interview->application->user_id === auth()->id(),
            403
        );

        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $interview->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            $validated['status'] === 'accepted'
                ? 'Mülakat kabul edildi.'
                : 'Mülakat reddedildi.'
        );
    }

    private function checkEmployerAccess(Application $application): void
    {
        abort_unless(
            $application->job->company &&
            $application->job->company->user_id === auth()->id(),
            403
        );
    }
}