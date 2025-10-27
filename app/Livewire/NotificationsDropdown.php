<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationsDropdown extends Component
{
    public $mode = 'desktop';
    public $notifications;
    public $unreadCount = 0;

    // protected $listeners = ['refreshNotifications' => '$refresh'];

    public function mount($mode = 'desktop')
    {
        $this->mode = in_array($mode, ['desktop', 'mobile']) ? $mode : 'desktop';
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = Auth::user();
        if ($user) {
            $this->notifications = $user->notifications()
                ->latest()
                ->take(8)
                ->get();

            $this->unreadCount = $user->unreadNotifications()->count();
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
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
        return view('livewire.notifications-dropdown');
    }
}
