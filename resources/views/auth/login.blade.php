@extends('layouts.frontend')

@section('title', 'تسجيل الدخول | كوافيري | My Kawafir')

@section('main')
<livewire:unified-auth />
    {{-- @include('auth.auth', ['activeTab' => 'login']) --}}
@endsection

@push('styles')
    <style>
        .btn-google-a {
            text-decoration: none;
            background: var(--white);
            border: 2px solid #87365b;
            color: var(--dark);
            padding: 12px 20px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-google-a:hover {
            text-decoration: none;
            border-color: #c95489;
            color: black;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(66, 133, 244, 0.2);
        }

        .btn-primary,
        .btn-google-f {
            padding: 12px 20px;
        }
    </style>
@endpush
