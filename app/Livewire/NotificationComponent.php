<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationComponent extends Component
{
    public $notifications;

    public function mount()
    {
        $user = Auth::user();
        $this->notifications = $user->notifications; // Lấy tất cả thông báo của người dùng hiện tại
    }

    protected $listeners = ['refreshNotifications'];

    public function refreshNotifications()
    {
        $user = Auth::user();
        $this->notifications = $user->notifications; // Lấy tất cả thông báo của người dùng hiện tại
    }

    public function render()
    {
        return view('livewire.notification-component', [
            'notifications' => $this->notifications
        ]);
    }
}
