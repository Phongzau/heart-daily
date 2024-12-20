@php
    use Carbon\Carbon;
    use App\Models\User;
    use App\Models\Message;

    $currentUser = auth()->user();

    if ($currentUser->role_id == 4) {
        $userIds = User::where('role_id', '<>', 4)->pluck('id');
    } else {
        $userIds = Message::where('receiver_id', $currentUser->id)
            ->pluck('sender_id')
            ->unique();
    }

    $latestMessages = Message::where(function ($query) use ($currentUser) {
        $query->where('sender_id', auth()->user()->id)->orWhere('receiver_id', auth()->user()->id);
    })
        ->whereIn('sender_id', $userIds)
        ->orWhereIn('receiver_id', $userIds)
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy(function ($message) use ($currentUser) {
            return $message->sender_id === auth()->user()->id ? $message->receiver_id : $message->sender_id;
        });
    $latestMessageTimes = [];
    foreach ($users as $user) {
        if (isset($latestMessages[$user->id])) {
            $latestMessage = $latestMessages[$user->id]->first();
            $latestMessageTimes[$user->id] = $latestMessage ? $latestMessage->created_at : null;
        } else {
            $latestMessageTimes[$user->id] = null;
        }
    }
    $users = User::whereIn('id', $userIds)->get();
    $users = $users->sortByDesc(function ($user) use ($latestMessageTimes) {
        return $latestMessageTimes[$user->id];
    });

    $receiverAvatar = Storage::url(auth()->user()->image);
@endphp
<section>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="chat3" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                                <div class="p-3">
                                    <div class="rounded mb-3">
                                        <h5 class="font-weight-bold mb-3 text-center text-lg">Nhân Viên Tư Vấn:</h5>
                                    </div>
                                    <div class="user-list-container"
                                        style="position: relative; height: 400px; overflow-y: auto;">
                                        @foreach ($users as $user)
                                            @php
                                                $latestMessage = App\Models\Message::where(function ($query) use (
                                                    $user,
                                                ) {
                                                    $query
                                                        ->where('sender_id', auth()->user()->id)
                                                        ->where('receiver_id', $user->id);
                                                })
                                                    ->orWhere(function ($query) use ($user) {
                                                        $query
                                                            ->where('sender_id', $user->id)
                                                            ->where('receiver_id', auth()->user()->id);
                                                    })
                                                    ->orderBy('created_at', 'desc')
                                                    ->first();
                                                $unreadCount = Message::where('sender_id', $user->id)
                                                    ->where('receiver_id', auth()->user()->id)
                                                    ->where('status', 0)
                                                    ->count();
                                            @endphp
                                            <a href="{{ route('chat', $user->id) }}" class="user-list-item">
                                                <div class="user-avatar">
                                                    <img src="{{ Storage::url($user->image) }}" alt="avatar">
                                                    <span class="badge-dot"
                                                        style="{{ $user->is_online ? 'display: block;' : 'display: none;' }}"></span>
                                                </div>
                                                <div class="user-info">
                                                    <p class="user-name">{{ $user->name }}</p>
                                                    <p
                                                        class="user-status {{ $latestMessage && $latestMessage->receiver_id == auth()->user()->id && $latestMessage->status == 0 ? 'font-weight-bold' : '' }}">
                                                        @if ($latestMessage)
                                                            @if (isset($latestMessage->message['file']) &&
                                                                    preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $latestMessage->message['file']))
                                                                [ Hình ảnh ]
                                                            @elseif (isset($latestMessage->message['file']) &&
                                                                    preg_match('/\.(pdf|doc|docx|xls|xlsx|ppt|pptx)$/i', $latestMessage->message['file']))
                                                                [ File ]
                                                            @elseif (isset($latestMessage->message['text']))
                                                                {{ Str::limit($latestMessage->message['text'], 20, '...') }}
                                                            @else
                                                                [ Tin nhắn không xác định ]
                                                            @endif
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="user-time">
                                                    <p>{{ $latestMessage ? $latestMessage->created_at->format('h:i A') : '' }}
                                                    </p>
                                                    @if ($unreadCount > 0)
                                                        <span
                                                            class="badge bg-danger user-notifications text-light">{{ $unreadCount }}</span>
                                                    @endif
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @if ($receiver_id)
                                <div class="col-md-6 col-lg-7 col-xl-8">
                                    <div class="pt-3 pe-3" id="chat-container"
                                        style="position: relative; height: 400px; overflow-y: auto;">
                                        @foreach ($messages as $message)
                                            @php
                                                $messageDate = Carbon::parse($message['created_at']);
                                                $isToday = $messageDate->isToday();
                                                $isSender = $message['sender']['name'] === auth()->user()->name;
                                                $avatar = $isSender
                                                    ? @$receiverAvatar
                                                    : Storage::url($message['sender']['image']);
                                                $messageFile = $message['message']['file'] ?? null;
                                                $messageText = htmlspecialchars(
                                                    $message['message']['text'] ?? '',
                                                    ENT_QUOTES,
                                                    'UTF-8',
                                                );
                                            @endphp

                                            <div
                                                class="d-flex flex-row {{ $isSender ? 'justify-content-end' : 'justify-content-start' }}">
                                                @unless ($isSender)
                                                    <img src="{{ $avatar }}" alt="avatar"
                                                        style="width: 30px; height: 100%;">&nbsp;
                                                @endunless
                                                <div>
                                                    <p class="small p-2 ms-3 mb-1 rounded-3 {{ $isSender ? 'bg-primary text-white' : 'bg-light' }}"
                                                        style="border-radius: 5px">
                                                        @if ($messageFile)
                                                            @if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $messageFile))
                                                                <img src="{{ asset('storage/' . $messageFile) }}"
                                                                    alt="Image"
                                                                    style="max-width: 300px; max-height: 200px; border-radius: 10px;" />
                                                            @else
                                                                <a class="{{ $isSender ? 'text-white' : '' }}"
                                                                    href="{{ asset('storage/' . $messageFile) }}"
                                                                    target="_blank">
                                                                    {{ pathinfo($messageFile, PATHINFO_BASENAME) }}
                                                                    (Download)
                                                                </a>
                                                            @endif
                                                        @endif
                                                        @if ($messageText)
                                                            {{ $messageText }}
                                                        @endif
                                                    </p>
                                                    <p class="small ms-3 mb-3 rounded-3 text-muted float-end">
                                                        {{ $isToday ? $messageDate->format('h:i A') : $messageDate->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                                @if ($isSender)
                                                    &nbsp;<img src="{{ $avatar }}" alt="avatar"
                                                        style="width: 30px; height: 100%;">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <form wire:submit.prevent="sendMessage()" class="form-container">
                                        <div class="text-muted d-flex justify-content-start align-items-center">
                                            <img src="{{ @$receiverAvatar }}" alt="avatar 3"
                                                style="width: 35px; height: auto;" />
                                            <textarea class="flex-grow m-2 textarea-custom" rows="1" cols="80" wire:model="message"
                                                placeholder="Message..." style="min-height: 40px;"
                                                oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';" onkeydown="handleKeyDown(event)"></textarea>
                                            <div class="file-preview ms-2">
                                                @if ($file)
                                                    @if ($file->getMimeType() && str_contains($file->getMimeType(), 'image'))
                                                        <img src="{{ $file->temporaryUrl() }}" alt="Preview"
                                                            style="max-width: 100%; max-height: 150px; border-radius: 5px;" />
                                                    @else
                                                        <span
                                                            class="text-muted">{{ $file->getClientOriginalName() }}</span>
                                                    @endif
                                                @endif
                                            </div>

                                            <input type="file" id="file-input" wire:model="file" class="d-none"
                                                accept="image/*,application/pdf" />
                                            <label for="file-input" class="ms-1 text-muted label-file-icon"
                                                style="cursor: pointer;">
                                                <i class="fas fa-paperclip"></i>
                                            </label>

                                            <button class="send-button ms-3" type="button" wire:click="sendMessage"
                                                aria-label="Send message">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="col-md-6 col-lg-7 col-xl-8">
                                    <p class="font-weight-bold mb-3 text-center text-lg">Vui lòng chọn một người để bắt
                                        đầu trò chuyện.</p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
