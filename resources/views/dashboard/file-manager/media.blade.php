@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('Media'), 'url' => route('dashboard.file-manager.media')],
    ]" :pageName="__('MEDIA MANAGER')" />
@endsection

@section('content')
<div class="container-fluid bulk-cate">
    <x-alert-message />
   

    <!-- Folders Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0 text-primary"><i class="fa fa-folder-open"></i> {{ __('Folders') }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($directories as $dir)
                    <div class="col-md-4 mb-3">
                        <div class="card o-hidden widget-cards h-100">
                            <div class="primary-box card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title"><i class="fa fa-folder font-primary"></i> {{ $dir['path'] }}</h5>
                                    <p class="card-text">{{ count($dir['files']) }} {{ __('Files') }}</p>
                                </div>
                                <a href="{{ route('dashboard.file-manager.folder', ['folder' => $dir['path']]) }}" class="btn btn-outline-primary mt-2">{{ __('View') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Search and Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <form class="form-inline search-form search-box w-100" method="GET" action="">
                <div class="form-group w-100">
                    <input class="form-control-plaintext w-100" type="search" name="search" placeholder="{{ __('Search..') }}" value="{{ request('search') }}">
                    <span class="d-sm-none mobile-search ms-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive table-desi">
                <table class="all-package coupon-table table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('File Name') }}</th>
                            <th>{{ __('URL') }}</th>
                            <th>{{ __('Operations') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($media as $index => $item)
                            <tr data-row-id="{{ $item->id }}">
                                <td>{{ $media->firstItem() + $index }}</td>
                                <td style="position: relative; min-width: 110px;">
                                    <div style="position: relative; display: inline-block;">
                                        <img src="{{ $item->url }}" alt="{{ $item->type }}" style="max-width: 80px; max-height: 60px; border-radius: 8px; box-shadow: 0 2px 6px #eee;">
                                        <form action="{{ route('dashboard.media.update', $item->id) }}" method="POST" enctype="multipart/form-data" style="position: absolute; bottom: 4px; right: 4px; margin: 0;">
                                            @csrf
                                            @method('PUT')
                                            <label style="cursor:pointer; margin-bottom:0; background:rgba(255,255,255,0.8); border-radius:50%; padding:4px; box-shadow:0 1px 4px #bbb;" title="{{ __('Update Image') }}">
                                                <i class="fa fa-pencil-alt text-primary"></i>
                                                <input type="file" name="file" accept="image/*" onchange="this.form.submit()" style="display:none;">
                                            </label>
                                        </form>
                                    </div>
                                </td>
                                <td>{{ $item->type }}</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" value="{{ $item->url }}" readonly>
                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="navigator.clipboard.writeText('{{ $item->url }}')"><i class="fa fa-copy"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('dashboard.file-manager.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('هل أنت متأكد من حذف الملف؟') }}')">
                                            <i class="fa fa-trash"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $media->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
