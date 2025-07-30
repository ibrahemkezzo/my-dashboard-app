@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.sub_services'), 'url' => route('dashboard.sub_services.index')],
        ['label' => __('dashboard.edit_sub_service'), 'url' => route('dashboard.sub_services.edit', $subService->id)],
    ]" :pageName="__('dashboard.edit_sub_service')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="card">
        <div class="card-header">
            <h3>{{ __('dashboard.edit_sub_service') }}</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('dashboard.sub_services.update', $subService) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('dashboard.sub_services._form', [
                    'subService' => $subService,
                    'services' => $services,
                    'submitText' => __('dashboard.update'),
                ])
            </form>
        </div>
    </div>
@endsection 