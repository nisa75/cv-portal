<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->get();

        $role = auth()->user()->role;

        return view('notifications.index', compact('notifications', 'role'));
    }

    public function read(DatabaseNotification $notification)
    {
        abort_unless(
            $notification->notifiable_id === auth()->id(),
            403
        );

        $notification->markAsRead();

        if (auth()->user()->role === 'employer') {
            return redirect('/employer/notifications');
        }

        return redirect('/candidate/notifications');
    }
}