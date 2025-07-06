<div class="page-sidebar">
    <div class="main-header-left d-none d-lg-block">
        <div class="logo-wrapper">
            <a href="index.html">
                <img class="d-none d-lg-block blur-up lazyloaded"
                    src="assets/images/dashboard/multikart-logo.png" alt="">
            </a>
        </div>
    </div>
    <div class="sidebar custom-scrollbar">
        <a href="javascript:void(0)" class="sidebar-back d-lg-none d-block"><i class="fa fa-times"
                aria-hidden="true"></i></a>
        <div class="sidebar-user">
            <img class="img-60" src="{{$user->url}}" alt="#">
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
                                    <a href="{{ route($subItem['url'] )}}">
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
                        <span>{{ __($item['label'])}}</span>
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>