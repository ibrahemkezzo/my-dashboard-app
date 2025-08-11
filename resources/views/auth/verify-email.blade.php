@extends('layouts.frontend')

@section('title', 'منصة حجز خدمات التجميل | كوافيري | My Kawafir')

@section('main')

    <main class="confirm-wrapper">
        <section class="confirm-card" role="status" aria-live="polite">
            <div class="icon-wrap" aria-hidden="true">
                <svg viewBox="0 0 24 24" class="mail-icon" width="64" height="64">
                    <path d="M4 6h16a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z" fill="none"
                        stroke="currentColor" stroke-width="1.75" />
                    <path d="m22 8-10 6L2 8" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>

            <h1 class="title">تحقّقي من بريدك الإلكتروني</h1>
            <p class="subtitle">
                أرسلنا رابط تأكيد إلى بريدك:
                <strong class="email">{{Auth::user()->email}}</strong>
            </p>

            <div class="tips">
                <p>هل يمكنك التحقق من بريدك الإلكتروني بالضغط على الرابط الذي أرسلناه إليك؟ إذا لم تستلم الرسالة، فسنرسل لك
                    رسالة أخرى بكل سرور.</p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                </div>
            @endif
            <div class="actions">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf


                    <button type="submit" class="btn btn-outline" type="button" aria-label="إعادة إرسال رسالة التأكيد">
                        إعادة الإرسال
                    </button>

                </form>


                    {{-- <a href="{{ route('profile.show') }}"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Edit Profile') }}</a> --}}
                    <a class="link-alt" href="{{ route('front.profile.account') }}" aria-label="تغيير البريد الإلكتروني">
                        هل البريد غير صحيح؟ غيّري البريد
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf

                        <button type="submit" class="btn btn-primary">
                            تسجيل الخروج
                        </button>
                    </form>

            </div>
    </main>
@endsection
@push('styles')
 <link rel="stylesheet" href="{{ asset('frontend/assets/css/email.css') }}">

@endpush
