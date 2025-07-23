@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.salons'), 'url' => route('dashboard.salons.index')],
        ['label' => __('dashboard.edit_salon'), 'url' => route('dashboard.salons.edit', $salon->id)],
    ]" :pageName="__('dashboard.edit_salon')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="card">
        <div class="card-header">
            <h3>{{ __('dashboard.edit_salon') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.salons.update', $salon) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @include('dashboard.salons._form_salon', [
                    'salon' => $salon,
                    'owners' => $owners,
                    'nextText' => __('dashboard.save'),
                ])
            </form>
        </div>
    </div>
@endsection
