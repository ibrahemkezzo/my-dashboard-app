@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.salons'), 'url' => route('dashboard.salons.index')],
        ['label' => $salon->name, 'url' => route('dashboard.salons.show', $salon)],
        ['label' => $subService->subService->name, 'url' => route('dashboard.salons.sub-services.show', [$salon, $subService])],
    ]" :pageName="$subService->subService->name" />
@endsection

@section('content')
    <x-alert-message />
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="mb-3">{{ $subService->subService->name }}</h4>
                        <p class="text-muted">{{ $subService->subService->service->name }}</p>
                        <div class="mb-3">
                            @if($subService->status)
                                <span class="badge bg-success">{{ __('dashboard.active') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('dashboard.inactive') }}</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('dashboard.salons.sub-services.edit', [$salon, $subService]) }}" class="btn btn-warning mb-">
                                <i class="fa fa-edit"></i> {{ __('dashboard.edit') }}
                            </a>
                            <form action="{{ route('dashboard.salons.sub-services.destroy', [$salon, $subService]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('dashboard.confirm_delete_service') }}')">
                                    <i class="fa fa-trash"></i> {{ __('dashboard.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('dashboard.service_details') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>{{ __('dashboard.service') }}:</strong> {{ $subService->subService->service->name }}</p>
                                <p><strong>{{ __('dashboard.sub_service') }}:</strong> {{ $subService->subService->name }}</p>
                                <p><strong>{{ __('dashboard.price') }}:</strong> {{ $subService->price }} {{ __('dashboard.currency') }}</p>
                                <p><strong>{{ __('dashboard.duration') }}:</strong> {{ $subService->duration }} {{ __('dashboard.minutes') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>{{ __('dashboard.status') }}:</strong>
                                    @if($subService->status)
                                        <span class="badge bg-success">{{ __('dashboard.active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('dashboard.inactive') }}</span>
                                    @endif
                                </p>
                                <p><strong>{{ __('dashboard.created_at') }}:</strong> {{ $subService->created_at->format('M j, Y') }}</p>
                                <p><strong>{{ __('dashboard.updated_at') }}:</strong> {{ $subService->updated_at->format('M j, Y') }}</p>
                            </div>
                        </div>

                        @if($subService->materials_used)
                            <div class="mt-3">
                                <h6>{{ __('dashboard.materials_used') }}</h6>
                                <p>{{ $subService->materials_used }}</p>
                            </div>
                        @endif

                        @if($subService->requirements)
                            <div class="mt-3">
                                <h6>{{ __('dashboard.requirements') }}</h6>
                                <p>{{ $subService->requirements }}</p>
                            </div>
                        @endif

                        @if($subService->special_notes)
                            <div class="mt-3">
                                <h6>{{ __('dashboard.special_notes') }}</h6>
                                <p>{{ $subService->special_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Service Images Section -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>{{ __('dashboard.service_images') }}</h5>
                    </div>
                    <div class="card-body">
                        @if($subService->media && $subService->media->count())
                            <div class="row mt-2">
                                @foreach($subService->media as $media)
                                    <div class="col-md-3 text-center mb-3">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/'.$media->path) }}" alt="service" style="width:150px;height:150px;object-fit:cover;border-radius:8px;">
                                            <div class="mt-2">
                                                <form action="{{ route('dashboard.media.update', $media->id) }}" method="POST" enctype="multipart/form-data" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="file" name="file" accept="image/*" style="width:120px;display:inline-block;">
                                                    <button type="submit" class="btn btn-sm btn-primary mt-1"><i class="fa fa-upload"></i></button>
                                                </form>
                                                <form action="{{ route('dashboard.media.destroy', $media->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger mt-1" onclick="return confirm('{{ __('dashboard.confirm_delete_image') }}')"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">{{ __('dashboard.no_service_images') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection