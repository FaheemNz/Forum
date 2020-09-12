<?php

namespace App\Http\Controllers;

use App\User;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    public function destroy($user, $notificationId)
    {
        auth()->user()->unreadNotifications()->findOrFail($notificationId)->markAsRead();
    }
}
