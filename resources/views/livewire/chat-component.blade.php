@php
    use Carbon\Carbon;
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
                                        <h5 class="font-weight-bold mb-3 text-center text-lg">Tư Vấn</h5>
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
                                            @endphp
                                            <a href="{{ route('chat', $user->id) }}" class="user-list-item">
                                                <div class="user-avatar">
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                        alt="avatar">
                                                    <span class="badge-dot"></span>
                                                </div>
                                                <div class="user-info">
                                                    <p class="user-name">{{ $user->name }}</p>
                                                    <p class="user-status">
                                                        {{ $latestMessage ? $latestMessage->message['text'] : '' }}</p>
                                                </div>
                                                <div class="user-time">
                                                    <p>{{ $latestMessage ? $latestMessage->created_at->format('h:i A') : '' }}
                                                    </p>
                                                    @if ($latestMessage && $latestMessage->receiver_id == auth()->user()->id && !$latestMessage->is_read)
                                                        <span class="badge bg-danger user-notifications">1</span>
                                                    @endif
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-7 col-xl-8">
                                <div class="pt-3 pe-3" id="chat-container"
                                    style="position: relative; height: 400px; overflow-y: auto;">
                                    @foreach ($messages as $message)
                                        @php
                                            $messageDate = Carbon::parse($message['created_at']);
                                            $isToday = $messageDate->isToday();
                                        @endphp
                                        @if (isset($message['message']['file']))
                                            @if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $message['message']['file']))
                                                <div
                                                    class="d-flex flex-row {{ $message['sender'] != auth()->user()->name ? 'justify-content-start' : 'justify-content-end' }}">
                                                    @if ($message['sender'] != auth()->user()->name)
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                                                            alt="avatar" style="width: 45px; height: 100%;">
                                                    @else
                                                        <div></div>
                                                    @endif
                                                    <div>
                                                        <img src="{{ asset('storage/' . $message['message']['file']) }}"
                                                            alt="Image"
                                                            style="max-width: 300px; max-height: 200px; border-radius: 10px;" />
                                                        @if (isset($message['message']['text']))
                                                            <p class="small p-2 ms-3 mb-1 rounded-3 bg-light">
                                                                {{ htmlspecialchars($message['message']['text'], ENT_QUOTES, 'UTF-8') }}
                                                            </p>
                                                        @endif
                                                        <p class="small ms-3 mb-3 rounded-3 text-muted float-end">
                                                            {{ $isToday ? $messageDate->format('h:i A') : $messageDate->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                    @if ($message['sender'] == auth()->user()->name)
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                            alt="avatar" style="width: 45px; height: 100%;">
                                                    @endif
                                                </div>
                                            @else
                                                <div
                                                    class="d-flex flex-row {{ $message['sender'] != auth()->user()->name ? 'justify-content-start' : 'justify-content-end' }}">
                                                    @if ($message['sender'] != auth()->user()->name)
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                                                            alt="avatar" style="width: 45px; height: 100%;">
                                                    @else
                                                        <div></div>
                                                    @endif
                                                    <div>
                                                        <p class="small p-2 ms-3 mb-1 rounded-3 bg-light">
                                                            <a href="{{ asset('storage/' . $message['message']['file']) }}"
                                                                target="_blank">
                                                                {{ pathinfo($message['message']['file'], PATHINFO_BASENAME) }}
                                                                (Download)
                                                            </a>
                                                        </p>
                                                        @if (isset($message['message']['text']))
                                                            <p class="small p-2 ms-3 mb-1 rounded-3 bg-light">
                                                                {{ htmlspecialchars($message['message']['text'], ENT_QUOTES, 'UTF-8') }}
                                                            </p>
                                                        @endif
                                                        <p class="small ms-3 mb-3 rounded-3 text-muted float-end">
                                                            {{ $isToday ? $messageDate->format('h:i A') : $messageDate->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                    @if ($message['sender'] == auth()->user()->name)
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                            alt="avatar" style="width: 45px; height: 100%;">
                                                    @endif
                                                </div>
                                            @endif
                                        @elseif (isset($message['message']['text']))
                                            <div
                                                class="d-flex flex-row {{ $message['sender'] != auth()->user()->name ? 'justify-content-start' : 'justify-content-end' }}">
                                                @if ($message['sender'] != auth()->user()->name)
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                                                        alt="avatar 1" style="width: 45px; height: 100%;">
                                                    <div>
                                                        <p class="small p-2 ms-3 mb-1 rounded-3 bg-light">
                                                            {{ htmlspecialchars($message['message']['text'], ENT_QUOTES, 'UTF-8') }}
                                                        </p>
                                                        <p class="small ms-3 mb-3 rounded-3 text-muted float-end">
                                                            {{ $isToday ? $messageDate->format('h:i A') : $messageDate->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                @else
                                                    <div>
                                                        <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">
                                                            {{ htmlspecialchars($message['message']['text'], ENT_QUOTES, 'UTF-8') }}
                                                        </p>
                                                        <p class="small me-3 mb-3 rounded-3 text-muted">
                                                            {{ $isToday ? $messageDate->format('h:i A') : $messageDate->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                        alt="avatar 1" style="width: 45px; height: 100%;">
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach


                                </div>

                                <form wire:submit.prevent="sendMessage()" class="form-container">
                                    <div class="text-muted d-flex justify-content-start align-items-center">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp"
                                            alt="avatar 3" style="width: 40px; height: auto;" />
                                        <textarea class="flex-grow m-2 textarea-custom" rows="1" cols="80" wire:model="message"
                                            placeholder="Message..." style="min-height: 40px;"
                                            oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';"></textarea>
                                        <input type="file" id="file-input" wire:model="file" class="d-none"
                                            accept="image/*,application/pdf" />
                                        <label for="file-input" class="ms-1 text-muted label-file-icon"
                                            style="cursor: pointer;">
                                            <i class="fas fa-paperclip"></i>
                                        </label>
                                        <button class="send-button ms-3" type="submit" aria-label="Send message">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
