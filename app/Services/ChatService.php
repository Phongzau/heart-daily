<?php

namespace App\Services;

use App\Models\Message;
use App\Models\User;

class ChatService
{
    public function assignToAdmin($customerId)
    {
        $admins = User::where('role_id', '<>', 4)
            ->where('is_block', 0)
            ->where('is_online', 1)
            ->withCount(['messages as active_chats' => function ($query) {
                $query->where('is_pending', 0);
            }])
            ->get()
            ->filter(fn($admin) => $admin->active_chats < 5);

        if ($admins->isEmpty()) {
            // Message::create([
            //     'sender_id' => $customerId,
            //     'receiver_id' => null,
            //     'is_pending' => 1,
            //     'priority' => time(),
            // ]);
            return null;
        }

        $admin = $admins->sortBy('id')->first();

        // Message::create([
        //     'sender_id' => $customerId,
        //     'receiver_id' => $admin->id,
        //     'is_pending' => 0,
        // ]);

        return $admin;
    }

    public function processPendingMessages()
    {
        $pendingMessages = Message::where('is_pending', 1)->orderBy('priority', 'asc')->get();

        foreach ($pendingMessages as $message) {
            $admin = $this->assignToAdmin($message->sender_id);
            if ($admin) {
                $message->update(['receiver_id' => $admin->id, 'is_pending' => 0]);
            }
        }
    }
}
