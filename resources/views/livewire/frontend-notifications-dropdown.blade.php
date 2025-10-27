{{-- resources/views/livewire/frontend-notifications-dropdown.blade.php --}}
<div wire:poll.5000ms="loadNotifications">
    @if($mode === 'desktop')
        {{-- ==================== DESKTOP VERSION ==================== --}}
        <div class="d-none d-lg-block position-relative">

            {{-- Desktop Button --}}
            <button id="notifications-btn-desktop"
                    class="bg-transparent border-0 p-0 position-relative"
                    type="button">
                <svg style="color: #a2416d;" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>

                @if($unreadCount > 0)
                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger"
                        style="font-size: 0.65rem; width: 18px; height: 18px;">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </button>

            {{-- Desktop Dropdown Menu --}}
            <ul id="notifications-menu-desktop"
                class="position-absolute bg-white shadow-lg rounded p-3"
                style="display: none; width: 300px; max-height: 400px; overflow-y: auto; top: 40px; right: auto; left:0; z-index: 1050; border: 1px solid #ddd;"
                dir="rtl">

                <li class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <span class="fw-bold" style="color: #87365b;">الإشعارات</span>
                    @if($unreadCount > 0)
                        <a href="#" wire:click.prevent="markAllAsRead"
                        class="small text-primary text-decoration-underline">
                            تحديد الكل كمقروء
                        </a>
                    @endif
                </li>

                @forelse($notifications as $notification)
                    <li class="border-bottom pb-2 mb-2">
                        <a href="{{ $notification->data['url'] ?? '#' }}"
                        wire:click.prevent="markAsRead('{{ $notification->id }}')"
                        class="text-decoration-none d-block p-2 rounded hover-bg-light">
                            <div class="d-flex align-items-start gap-2">
                                <div class="flex-shrink-0">
                                    <div class="avatar avatar-sm rounded-circle d-flex align-items-center justify-content-center
                                                bg-{{ $notification->data['color'] ?? 'info' }} text-white"
                                        style="width: 36px; height: 36px;">
                                        <i class="fas {{ $notification->data['icon'] ?? 'fa-bell' }} fa-sm"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 text-end">
                                    <h6 class="mb-1 fw-bold small" style="color: #333;">
                                        {{ $notification->data['title'] }}
                                    </h6>
                                    <p class="mb-1 text-muted x-small lh-sm">
                                        {!! Str::limit(strip_tags($notification->data['message']), 60) !!}
                                    </p>
                                    <small class="text-muted d-block">
                                        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                @empty
                    <li class="text-center py-4 text-muted small">
                        <i class="fas fa-bell-slash fa-2x mb-2 d-block" style="color: #ddd;"></i>
                        لا توجد إشعارات جديدة
                    </li>
                @endforelse

                {{-- <li class="text-center mt-2 pt-2 border-top">
                    <a href="{{ route('front.notifications') }}"
                    class="small text-primary text-decoration-underline">
                        عرض الكل
                    </a>
                </li> --}}
            </ul>
        </div>

    @elseif($mode === 'mobile')
        {{-- ==================== MOBILE VERSION ==================== --}}
        <div class="d-lg-none w-100 mb-3">

            {{-- Mobile Button --}}
            <button id="notifications-btn-mobile"
                    class="w-100 text-start d-flex align-items-center justify-content-between p-3 rounded bg-white border"
                    style="border: 1px solid #e0c7d3;"
                    type="button">
                <div class="d-flex align-items-center">
                    <svg style="color: #a2416d;" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell me-2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="ms-2 me-2">الإشعارات</span>
                    @if($unreadCount > 0)
                        <span class="badge bg-danger rounded-pill ms-2 small">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </div>
                <i class="fas fa-chevron-down"></i>
            </button>

            {{-- Mobile Dropdown Menu --}}
            <ul id="notifications-menu-mobile"
                class="position-absolute bg-white shadow-lg rounded p-3 mt-2"
                style="display: none; max-height: 350px; z-index: 1050; overflow-y: auto; border: 1px solid #ddd;"
                dir="rtl">

                <li class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                    <span class="fw-bold" style="color: #87365b;">الإشعارات</span>
                    @if($unreadCount > 0)
                        <a href="#" wire:click.prevent="markAllAsRead"
                        class="small text-primary text-decoration-underline">
                            تحديد الكل كمقروء
                        </a>
                    @endif
                </li>

                @forelse($notifications as $notification)
                    <li class="border-bottom pb-2 mb-2">
                        <a href="{{ $notification->data['url'] ?? '#' }}"
                        wire:click.prevent="markAsRead('{{ $notification->id }}')"
                        class="text-decoration-none d-block p-2 rounded hover-bg-light">
                            <div class="d-flex align-items-start gap-2">
                                <div class="flex-shrink-0">
                                    <div class="avatar avatar-sm rounded-circle d-flex align-items-center justify-content-center
                                                bg-{{ $notification->data['color'] ?? 'info' }} text-white"
                                        style="width: 36px; height: 36px;">
                                        <i class="fas {{ $notification->data['icon'] ?? 'fa-bell' }} fa-sm"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 text-end">
                                    <h6 class="mb-1 fw-bold small" style="color: #333;">
                                        {{ $notification->data['title'] }}
                                    </h6>
                                    <p class="mb-1 text-muted x-small lh-sm">
                                        {!! Str::limit(strip_tags($notification->data['message']), 60) !!}
                                    </p>
                                    <small class="text-muted d-block">
                                        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                @empty
                    <li class="text-center py-4 text-muted small">
                        <i class="fas fa-bell-slash fa-2x mb-2 d-block" style="color: #ddd;"></i>
                        لا توجد إشعارات جديدة
                    </li>
                @endforelse

                {{-- <li class="text-center mt-2 pt-2 border-top">
                    <a href="{{ route('front.notifications') }}"
                    class="small text-primary text-decoration-underline">
                        عرض الكل
                    </a>
                </li> --}}
            </ul>
        </div>
    @endif
</div>

{{-- ==================== JavaScript منفصل لكل نسخة (Desktop + Mobile) ==================== --}}



