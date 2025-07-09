@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.cities'), 'url' => route('dashboard.cities.index')],
        ['label' => __('dashboard.edit_city'), 'url' => route('dashboard.cities.edit', $city->id)],
    ]" :pageName="__('dashboard.edit_city')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="card">
        <div class="card-header">
            <h3>{{ __('dashboard.edit_city') }}</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <div class="flex items-center">
                        <i class="fa fa-exclamation-circle me-2 text-red-700"></i>
                        <strong class="font-bold">أخطاء في النموذج:</strong>
                    </div>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('dashboard.cities.update', $city->id) }}" method="POST" class="needs-validation">
                @csrf
                @method('PUT')
                @include('dashboard.cities._form', [
                    'city' => $city,
                    'submitText' => __('dashboard.update'),
                ])
            </form>
        </div>
    </div>
@endsection
