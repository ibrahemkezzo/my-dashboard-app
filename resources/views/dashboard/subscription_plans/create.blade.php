@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.subscription_plans'), 'url' => route('dashboard.subscription-plans.index')],
        ['label' => __('dashboard.create_subscription_plan'), 'url' => route('dashboard.subscription-plans.create')],
    ]" :pageName="__('dashboard.create_subscription_plan')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="card">
        <div class="card-header">
            <h3>{{ __('dashboard.create_subscription_plan') }}</h3>
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
            <form action="{{ route('dashboard.subscription-plans.store') }}" method="POST">
                @csrf
                @include('dashboard.subscription_plans._form', [
                    'subscriptionPlan' => null,
                    'submitText' => __('dashboard.save'),
                ])
            </form>
        </div>
    </div>
@endsection
