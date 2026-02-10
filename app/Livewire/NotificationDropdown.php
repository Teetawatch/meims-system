<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationDropdown extends Component
{
    public function getNotificationsProperty()
    {
        $user = $this->getUser();
        return $user ? $user->unreadNotifications()->limit(5)->get() : [];
    }

    public function getUnreadCountProperty()
    {
        $user = $this->getUser();
        return $user ? $user->unreadNotifications()->count() : 0;
    }

    public function markAsRead($notificationId)
    {
        $user = $this->getUser();
        if ($user) {
            $notification = $user->notifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
                 // Redirect logic based on notification type if needed
                 // e.g., redirect to announcement detail
            }
        }
    }

    public function markAllAsRead()
    {
        $user = $this->getUser();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
    }

    private function getUser()
    {
        if (Auth::guard('web')->check()) return Auth::guard('web')->user();
        if (Auth::guard('student')->check()) return Auth::guard('student')->user();
        if (Auth::guard('guardian')->check()) return Auth::guard('guardian')->user();
        return null;
    }

    public function render()
    {
        return view('components.notification-dropdown');
    }
}
