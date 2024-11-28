<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationAdminComponent extends Component
{
    public $notifications;

    public function mount()
    {
        $user = Auth::user();
        $this->notifications = $user->notifications;
    }

    protected $listeners = ['refreshAdminNotifications'];

    public function refreshAdminNotifications()
    {
        $user = Auth::user();
        $this->notifications = $user->notifications;
    }

    public function render()
    {
        return view(
            'livewire.notification-admin-component',
            [
                'notifications' => $this->notifications,
            ]
        );
    }
}
