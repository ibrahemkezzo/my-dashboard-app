@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.salons'), 'url' => route('dashboard.salons.index')],
        ['label' => __('dashboard.create_salon'), 'url' => route('dashboard.salons.create.step1')],
    ]" :pageName="__('dashboard.create_salon')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="card">
        <div class="card-header">
            <h3>{{ __('dashboard.create_salon') }} - {{ __('Step 1') }}</h3>
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
            <form action="{{ route('dashboard.salons.store.step1') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('dashboard.salons._form_salon', [
                    'salon' => null,
                    'owners' => $owners,
                    'nextText' => __('Next'),
                ])
            </form>
        </div>
    </div>
@endsection 