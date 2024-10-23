<?php

namespace App\Livewire;

use App\Events\MessageSendEvent;
use App\Models\Message;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChatComponent extends Component
{
    use WithFileUploads;
    public $users;
    public $user;
    public $sender_id;
    public $receiver_id;
    public $message = '';
    public $messages = [];
    public $file;

    public function mount($user_id)
    {
        $this->sender_id = auth()->user()->id;
        $this->receiver_id = $user_id;


        $this->users = User::where('id', '!=', $this->sender_id)->get();


        $messages = Message::where(function ($query) {
            $query->where('sender_id', $this->sender_id)
                ->where('receiver_id', $this->receiver_id);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->receiver_id)
                ->where('receiver_id', $this->sender_id);
        })
            ->with('sender:id,name', 'receiver:id,name')
            ->get();

        foreach ($messages as $message) {
            $this->appendChatMessage($message);
        }
        $this->markMessagesAsRead();
        $this->user = User::whereId($user_id)->first();
    }

    public function render()
    {
        return view('livewire.chat-component');
    }

    public function sendMessage()
    {
        if (empty($this->message) && !$this->file) {
            return;
        }
        $chatMessage = new Message();
        $chatMessage->sender_id = $this->sender_id;
        $chatMessage->receiver_id = $this->receiver_id;
        if ($this->file) {
            $filePath = $this->file->store('uploads', 'public');
            $chatMessage->message = [
                'text' => $this->message,
                'file' => $filePath
            ];
        } else {
            $chatMessage->message = [
                'text' => $this->message,
                'file' => null
            ];
        }

        $chatMessage->save();

        $this->appendChatMessage($chatMessage);
        broadcast(new MessageSendEvent($chatMessage))->toOthers();

        $this->message = '';
        $this->file = null;
        $this->dispatch('messageSent');
    }


    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenForMessage($event)
    {
        $chatMessage = Message::whereId($event['message']['id'])
            ->with('sender:id,name', 'receiver:id,name')
            ->first();

        $this->appendChatMessage($chatMessage);
    }

    public function appendChatMessage($message)
    {
        $this->messages[] = [
            'id' => $message->id,
            'message' => $message->message,
            'sender' => $message->sender->name,
            'receiver' => $message->receiver->name,
            'created_at' => $message->created_at
        ];
    }
    public function markMessagesAsRead()
    {
        Message::where('receiver_id', $this->sender_id)
            ->where('sender_id', $this->receiver_id)
            ->where('status', 0) // Chỉ lấy tin nhắn chưa đọc
            ->update(['status' => 1]); // Đánh dấu là đã đọc
    }
}
