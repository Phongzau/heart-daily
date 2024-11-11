<ul id="notification-dropdown" class="dropdown-menu"
    style="max-width: 355px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);left: 666px;top:70%; max-height: 300px; /* Giới hạn chiều cao của dropdown */
    overflow-y: auto;">
    {{-- max-width: 30%;
    border-radius: 8px;
    box-shadow: rgba(0, 0, 0, 0.15) 0px 4px 10px;
    left: 55%;
    top: 70%;
    max-height: 300px;
    overflow-y: auto;
    display: block; --}}
    <div style="padding: 10px 15px;border-bottom: 1px solid #f0f0f0;">
        <span style="font-size: 17px; font-weight: 500">Thông báo</span>
    </div>

    @if ($notifications && $notifications->isNotEmpty())
        @foreach ($notifications as $notification)
            <li class="notification-item">
                <span class="notification-text">{{ $notification->data['message'] ?? 'No message' }}</span>
                <span style="color: #6777EF"
                    class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
            </li>
        @endforeach
    @else
        <li class="notification-item">
            <span class="notification-text">Không có thông báo nào</span>
            <span style="color: #6777EF" class="notification-time"></span>
        </li>
    @endif

</ul>
