<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FrontendNotificationsDropdown extends Component
{
    public $mode = 'desktop';
    public $notifications;
    public $unreadCount;

    public function mount($mode = 'desktop')
    {
        $this->mode = in_array($mode, ['desktop', 'mobile']) ? $mode : 'desktop';
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Auth::user()->notifications()
            ->latest()
            ->take(8)
            ->get();

        $this->unreadCount = Auth::user()->unreadNotifications()->count();
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }
    public function render()
    {
        return view('livewire.frontend-notifications-dropdown');
    }
}
