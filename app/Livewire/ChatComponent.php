<?php

namespace App\Livewire;

use App\Events\MessageSendEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
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

    public function render()
    {
        return view('livewire.chat-component');
    }

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
            ->with('sender:id,name,image', 'receiver:id,name,image')
            ->get()->toArray();
            
        $this->checkAndSendThankYouMessage();
        foreach ($messages as $message) {
            $this->appendChatMessage($message);
        }
        

        $this->markMessagesAsRead();
        // $this->user = User::whereId($user_id)->first();
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
        


        $existingMessages = Message::where(function ($query) {
            $query->where('sender_id', $this->sender_id)
                ->where('receiver_id', $this->receiver_id);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->receiver_id)
                ->where('receiver_id', $this->sender_id);
        })->count();

        if ($existingMessages === 1) {
            $this->sendWelcomeMessage();
        }
        $this->checkAndSendThankYouMessage();
        broadcast(new MessageSendEvent($chatMessage))->toOthers();
        $this->message = '';
        $this->file = null;
        $this->dispatch('messageSent');
        $this->markMessagesAsRead();
    }

    public function sendWelcomeMessage()
    {
        $welcomeMessage = new Message();
        $welcomeMessage->sender_id = $this->receiver_id;
        $welcomeMessage->receiver_id = $this->sender_id;
        $welcomeMessage->message = [
            'text' => 'Xin chào! Cảm ơn bạn đã liên hệ. Chúng tôi sẵn sàng hỗ trợ bạn.',
            'file' => null
        ];

        $welcomeMessage->save();


        $this->appendChatMessage($welcomeMessage);
        broadcast(new MessageSendEvent($welcomeMessage))->toOthers();
    }


    public function checkAndSendThankYouMessage()
    {
        $thankYouMessageSent = Cache::get("thank_you_message_sent_{$this->sender_id}_{$this->receiver_id}");
        if ($thankYouMessageSent) {
            $this->checkAndDeleteMessages();
            return;
        }
        $lastMessage = Message::where(function ($query) {
            $query->where('sender_id', $this->sender_id)
                ->where('receiver_id', $this->receiver_id);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->receiver_id)
                ->where('receiver_id', $this->sender_id);
        })
            ->latest('created_at')
            ->first();

        if (!$lastMessage) {
            return;
        }
        $now = now();
        $lastMessageTime = $lastMessage->created_at;
        $sender = User::find($lastMessage->sender_id);
        if ($sender->role_id != 4 && $lastMessageTime->diffInMinutes($now) >= 2) {
            $senderId = $lastMessage->sender_id;
            $firstMessage = Message::where(function ($query) use ($senderId) {
                $query->where('sender_id', $senderId)
                    ->where('receiver_id', $this->receiver_id);
            })->orWhere(function ($query) use ($senderId) {
                $query->where('sender_id', $this->receiver_id)
                    ->where('receiver_id', $senderId);
            })
                ->oldest('created_at')
                ->first();
            if (!$firstMessage) {
                return;
            }

            $receiverId = $firstMessage->sender_id;
            $receiver = User::find($receiverId);
            if (!$receiver || $receiver->role_id != 4) {
                return;
            }

            $thankYouMessage = new Message();
            $thankYouMessage->sender_id = $senderId;
            $thankYouMessage->receiver_id = $receiver->id;
            $thankYouMessage->message = ['text' => 'Cảm ơn bạn đã liên hệ với chúng tôi! Bạn còn vấn đề gì cần được hỗ trợ không ạ. Nếu không chúng tôi xin kết thúc sau 5 phút nữa. Chúc bạn mua hàng vui vẻ!', 'file' => null];
            $thankYouMessage->save();
            
            $this->appendChatMessage($thankYouMessage);
            broadcast(new MessageSendEvent($thankYouMessage))->toOthers();
            Cache::put("thank_you_message_sent_{$this->sender_id}_{$this->receiver_id}", true, now()->addMinutes(10));
        }
    }
    public function checkAndDeleteMessages()
    {
        $thankYouMessageSent = Cache::get("thank_you_message_sent_{$this->sender_id}_{$this->receiver_id}");
        if (!$thankYouMessageSent) {
            return;
        }

        $lastMessage = Message::where(function ($query) {
            $query->where('sender_id', $this->sender_id)
                ->where('receiver_id', $this->receiver_id);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->receiver_id)
                ->where('receiver_id', $this->sender_id);
        })
            ->latest('created_at')
            ->first();
        if (!$lastMessage) {
            return;
        }
        $now = now();
        $lastMessageTime = $lastMessage->created_at;
        if ($lastMessageTime->diffInMinutes($now) >= 1) {
            Message::where(function ($query) {
                $query->where('sender_id', $this->sender_id)
                    ->where('receiver_id', $this->receiver_id);
            })->orWhere(function ($query) {
                $query->where('sender_id', $this->receiver_id)
                    ->where('receiver_id', $this->sender_id);
            })->delete();
            Cache::forget("thank_you_message_sent_{$this->sender_id}_{$this->receiver_id}");
            $this->messages = [];  
            $this->dispatch('messagesDeleted');
        }
    }



    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenForMessage($event)
    {
        $chatMessage = Message::whereId($event['message']['id'])
            ->with('sender:id,name,image', 'receiver:id,name,image')
            ->first();

        $this->appendChatMessage($chatMessage);
        $this->checkAndSendThankYouMessage();
    }

    public function appendChatMessage($message)
{
    $this->messages[] = [
        'id' => $message['id'],
        'message' => $message['message'],
        'sender' => [
            'name' => $message['sender']['name'],
            'image' => $message['sender']['image'],
        ],
        'receiver' => [
            'name' => $message['receiver']['name'],
            'image' => $message['receiver']['image'],
        ],
        'created_at' => $message['created_at'],
    ];
}

    public function markMessagesAsRead()
    {
        Message::where('receiver_id', $this->sender_id)
            ->where('sender_id', $this->receiver_id)
            ->where('status', 0)
            ->update(['status' => 1]);
    }
}
