@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.media'), 'url' => route('dashboard.file-manager.media')],
        ['label' => $folder, 'url' => '']
    ]" :pageName="__('dashboard.folder') . ': ' . $folder" />
@endsection

@section('content')
<div class="container-fluid bulk-cate">
    <div class="mb-3">
        <a href="{{ route('dashboard.file-manager.media') }}" class="btn btn-secondary">{{ __('dashboard.back_to_folders') }}</a>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0 text-primary"><i class="fa fa-folder-open"></i> {{ __('dashboard.folder') }}: {{ $folder }}</h6>
        </div>
        <div class="card-body">
            <x-alert-message />
            @if($directories->count())
                <div class="row mb-4">
                    @foreach ($directories as $subdir)
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title"><i class="fa fa-folder font-primary"></i> {{ basename($subdir) }}</h5>
                                    <a href="{{ route('dashboard.file-manager.folder', ['folder' => $folder . '/' . basename($subdir)]) }}" class="btn btn-outline-primary mt-2">{{ __('dashboard.view') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="row">
                @forelse ($files as $file)
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                @if (preg_match('/\.(jpg|jpeg|png|gif|ico)$/i', $file))
                                    <img src="{{ asset('storage/' . $file) }}" alt="{{ basename($file) }}" style="max-width: 100%; max-height: 120px; border-radius: 8px; box-shadow: 0 2px 6px #eee;">
                                @else
                                    <i class="fa fa-file fa-3x mb-2"></i>
                                @endif
                                <div class="mt-2 small">{{ basename($file) }}</div>
                                <div class="input-group mt-2">
                                    <input type="text" class="form-control form-control-sm" value="{{ asset('storage/' . $file) }}" readonly>
                                    <button class="btn btn-outline-secondary btn-sm" type="button" onclick="navigator.clipboard.writeText('{{ asset('storage/' . $file) }}')"><i class="fa fa-copy"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">{{ __('dashboard.no_files_found_in_folder') }}</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection 