@extends('layouts.frontend')

@section('title',config('app.name') . ' | ' .config('app.name_ar') .'  منصة حجز خدمات التجميل | ')

@section('main')
    <x-alert-message />
    <form action="{{ route('front.salons.store.step2',$salon) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('frontend.salons.hairdresser-auth-2')
        {{-- @include('dashboard.salons._form_services', [
            'salon' => null,
            'subServices' => $subServices,
            'allServices' => $allServices,
            'saveText' => __('Save'),
        ]) --}}

        {{-- <button type="submit"> تسجيل</button> --}}
    </form>
@endsection
