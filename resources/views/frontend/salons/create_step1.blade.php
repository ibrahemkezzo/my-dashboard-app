@extends('layouts.frontend')

{{-- @section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.salons'), 'url' => route('dashboard.salons.index')],
        ['label' => __('dashboard.create_salon'), 'url' => route('dashboard.salons.create.step1')],
    ]" :pageName="__('dashboard.create_salon')" />
@endsection --}}

@section('main')

<x-alert-message />
    {{-- <div class="card">
        <div class="card-body"> --}}

            <form action="{{ route('front.salons.store.step1') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('frontend.salons.hairdresser-auth-1')
            </form>
        {{-- </div>
    </div> --}}
@endsection
