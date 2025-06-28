
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-lg-6">
                <div class="page-header-left">
                    <h3>{{ $pageName }}
                        {{-- هنا يجب تمرير اس الصفحة --}}
                        <small>Multikart Admin panel</small>
                    </h3>
                </div>
            </div>
            <div class="col-lg-6">
                <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item">
                        <a href="index.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </a>
                    </li>
                    @foreach ($breadcrumbs as $index => $breadcrumb)
                        <li class="breadcrumb-item {{ $index === count($breadcrumbs) - 1 ? 'active' : '' }}">
                            @if ($index === count($breadcrumbs) - 1)
                                {{ $breadcrumb['label'] }}
                            @else
                                <a href="{{ $breadcrumb['url'] }}">
                                        {{ $breadcrumb['label'] }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>