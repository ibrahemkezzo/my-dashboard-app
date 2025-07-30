<div class="page-sidebar">
    <div class="main-header-left d-none d-lg-block">
        <div class="logo-wrapper">
            <a href="{{route('dashboard.index')}}">
                <img class="d-none d-lg-block blur-up lazyloaded"
                    style="height:60px; "
                    src="{{asset('storage/'.$cover->value)}}" alt="">
            </a>
        </div>
    </div>
    <div class="sidebar custom-scrollbar">
        <a href="javascript:void(0)" class="sidebar-back d-lg-none d-block"><i class="fa fa-times"
                aria-hidden="true"></i></a>
        <div class="sidebar-user">
            <div class="align-self-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-users font-danger">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
            </div>
            {{-- <img class="img-60" src="{{asset('storage/'.$favicon->value)}}" alt="#"> --}}
            {{-- <i style="color: white;" class="fa fa-user"></i> --}}
            <div>
                <h6 class="f-14">{{ $user->name }}</h6>
                @foreach ($user->getRoleNames() as $role)
                    <p>{{ $role }}</p>
                @endforeach
            </div>
        </div>
        <ul class="sidebar-menu">
            @foreach ($sidebarItems as $item)
                <li class="{{ isset($item['active']) && $item['active'] ? 'active' : '' }}">
                    @if (isset($item['submenu']))
                        <a class="sidebar-header {{ isset($item['active']) && $item['active'] ? 'active' : '' }}"
                            href="{{ $item['url'] }}">
                            {!! $item['icon'] !!}
                            <span>{{ __($item['label']) }}</span>
                            <i class="fa fa-angle-right pull-right"></i>
                        </a>
                        <ul class="sidebar-submenu">
                            @foreach ($item['submenu'] as $subItem)
                                <li>
                                    <a href="{{ route($subItem['url']) }}">
                                        <i class="fa fa-circle"></i>
                                        <span>{{ __($subItem['label']) }}</span>
                                        @if (isset($subItem['submenu']))
                                            <i class="fa fa-angle-right pull-right"></i>
                                        @endif
                                    </a>
                                    @if (isset($subItem['submenu']))
                                        <ul class="sidebar-submenu">
                                            @foreach ($subItem['submenu'] as $subSubItem)
                                                <li>
                                                    <a href="{{ $subSubItem['url'] }}">
                                                        <i class="fa fa-circle"></i>
                                                        {{ __($subSubItem['label']) }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <a class="sidebar-header {{ isset($item['active']) && $item['active'] ? 'active' : '' }}"
                            href="{{ route($item['url']) }}">
                            {!! $item['icon'] !!}
                            <span>{{ __($item['label']) }}</span>
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
