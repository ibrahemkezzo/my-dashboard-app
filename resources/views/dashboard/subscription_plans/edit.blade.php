@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('dashboard.subscription_plans'), 'url' => route('dashboard.subscription-plans.index')],
        ['label' => __('dashboard.edit_subscription_plan'), 'url' => '#'],
    ]" :pageName="__('dashboard.edit_subscription_plan')" />
@endsection

@section('content')
    <x-alert-message />
    <div class="card">
        <div class="card-header">
            <h3>{{ __('dashboard.edit_subscription_plan') }}</h3>
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
            <form action="{{ route('dashboard.subscription-plans.update', $plan->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('dashboard.subscription_plans._form', [
                    'subscriptionPlan' => $plan,
                    'submitText' => __('dashboard.update'),
                ])
            </form>
        </div>
    </div>
@endsection
