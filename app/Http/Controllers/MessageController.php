<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'candidate') {
            $conversations = $user->candidateConversations()
                ->with([
                    'application.job.company',
                    'employer',
                    'messages' => function ($query) {
                        $query->latest();
                    },
                ])
                ->latest('updated_at')
                ->get();
        } else {
            $conversations = $user->employerConversations()
                ->with([
                    'application.job.company',
                    'candidate',
                    'messages' => function ($query) {
                        $query->latest();
                    },
                ])
                ->latest('updated_at')
                ->get();
        }

        return view('messages.index', compact('conversations'));
    }

    public function createFromApplication(Application $application)
    {
        $user = auth()->user();

        $job = $application->job()->with('company')->first();

        abort_unless(
            $job &&
            $job->company &&
            (
                $application->user_id === $user->id ||
                $job->company->user_id === $user->id
            ),
            403
        );

        $conversation = Conversation::firstOrCreate(
            [
                'application_id' => $application->id,
            ],
            [
                'candidate_id' => $application->user_id,
                'employer_id' => $job->company->user_id,
            ]
        );

        return redirect('/messages/' . $conversation->id);
    }

    public function show(Conversation $conversation)
    {
        $this->checkAccess($conversation);

        $conversation->load([
            'application.job.company',
            'candidate',
            'employer',
            'messages.sender',
        ]);

        $conversation->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', auth()->id())
            ->update([
                'read_at' => now(),
            ]);

        return view('messages.show', compact('conversation'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $this->checkAccess($conversation);

        $validated = $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'body' => $validated['body'],
        ]);

        $conversation->touch();

        return redirect('/messages/' . $conversation->id);
    }

    private function checkAccess(Conversation $conversation): void
    {
        abort_unless(
            $conversation->candidate_id === auth()->id() ||
            $conversation->employer_id === auth()->id(),
            403
        );
    }
}