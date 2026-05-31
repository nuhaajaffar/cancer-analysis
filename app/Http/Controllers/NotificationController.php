<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AppNotification::where('user_id', session('user_id'))
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = AppNotification::where('user_id', session('user_id'))
            ->findOrFail($id);

        $notification->update([
            'is_read' => true,
        ]);

        return back()->with('success', 'Notification marked as read.');
    }
}