<div class="page-main-header" dir="rtl">
    <div class="main-header-right row">
        <div class="main-header-left d-lg-none w-auto">
            <div class="logo-wrapper">
                {{-- <a href="index.html">
                    <img class="blur-up lazyloaded d-block d-lg-none" src="{{ asset('frontend/assets/img/logo.png') }}"
                        alt="">
                </a> --}}
                <div  class="onhover-dropdown">
                    <div class="media align-items-center">
                        {{-- @dd($favicon->value) --}}
                        <img class="align-self-center   d-block d-lg-none"
                            src="{{ asset('storage/' . $logo->value) }}" alt="header-user">
                        {{-- <div class="dotted-animation">
                            <span class="animate-circle"></span>
                            <span class="main-circle"></span>
                        </div> --}}
                    </div>
                    <ul  class="profile-dropdown onhover-show-div p-20 profile-dropdown-hover">

                        <li>
                            <a href="{{ route('front.home') }}" class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-home ms-2 mt-2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span style="color: #680d48;">

                                    {{ __('dashboard.frontend') }}
                                </span>
                            </a>
                        </li>
                        <li class="mt-3">
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out ms-2 ">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span class="mb" style="color: #680d48;">

                                    {{ __('dashboard.logout') }}
                                </span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mobile-sidebar w-auto" >
            <div class="media-body text-end switch-sm">
                <label class="switch">
                    <a href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-align-left" id="sidebar-toggle">
                            <line x1="21" y1="10" x2="0" y2="10"></line>
                            <line x1="21" y1="6" x2="5" y2="6"></line>
                            <line x1="21" y1="14" x2="5" y2="14"></line>
                            <line x1="21" y1="18" x2="0" y2="18"></line>
                        </svg>
                    </a>
                </label>
            </div>
        </div>

        <div class="nav-right col">
            <ul class="nav-menus">
                <li>
                    <form class="form-inline search-form">
                        <div class="form-group">
                            <input class="form-control-plaintext" type="search"
                                placeholder="{{ __('dashboard.search_placeholder') }}">
                            <span class="d-sm-none mobile-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65">
                                    </line>
                                </svg>
                            </span>
                        </div>
                    </form>
                </li>
                <li>
                    <a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"
                        title="{{ __('dashboard.fullscreen') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-maximize-2">
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <polyline points="9 21 3 21 3 15"></polyline>
                            <line x1="21" y1="3" x2="14" y2="10"></line>
                            <line x1="3" y1="21" x2="10" y2="14"></line>
                        </svg>
                    </a>
                </li>
                <li class="onhover-dropdown">
                    <a class="txt-dark" href="javascript:void(0)">
                        <h6>{{ __('dashboard.language') }}</h6>
                    </a>
                    <ul class="language-dropdown onhover-show-div p-20">
                        {{-- <li>
                            <a href="javascript:void(0)" data-lng="en">
                                <i class="flag-icon flag-icon-is"></i>{{ __('dashboard.english') }}</a>
                        </li> --}}
                        <li>
                            <a href="javascript:void(0)" data-lng="ar">
                                <i class="flag-icon flag-icon-sa"></i>{{ __('dashboard.arabic') }}</a>
                        </li>
                    </ul>
                </li>

                <li class="onhover-dropdown">
                    <div class="media align-items-center">
                        {{-- @dd($favicon->value) --}}
                        <img class="align-self-center pull-right img-50 blur-up lazyloaded"
                            src="{{ asset('storage/' . $logo->value) }}" alt="header-user">
                        <div class="dotted-animation">
                            <span class="animate-circle"></span>
                            <span class="main-circle"></span>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div p-20 profile-dropdown-hover">

                        <li>
                            <a href="{{ route('front.home') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> {{ __('dashboard.frontend') }}
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-log-out mr-2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>{{ __('dashboard.logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="d-lg-none mobile-toggle pull-right">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="feather feather-more-horizontal">
                    <circle cx="12" cy="12" r="1"></circle>
                    <circle cx="19" cy="12" r="1"></circle>
                    <circle cx="5" cy="12" r="1"></circle>
                </svg>
            </div>
        </div>
    </div>
</div>
