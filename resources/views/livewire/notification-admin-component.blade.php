            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Thông báo
                    <div class="float-right">
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @foreach ($notifications as $notification)
                        <a href="@if (isset($notification->data['url'])) {{ $notification->data['url'] }} @endif"
                            class="dropdown-item dropdown-item-unread">
                            <div class="dropdown-item-desc">
                                {{ $notification->data['message'] }}
                                <div class="time text-primary">{{ $notification->created_at->diffForHumans() }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
