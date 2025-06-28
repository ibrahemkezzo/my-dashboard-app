
@extends('layouts.dashboard')


@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
        ['label' => __('User'), 'url' => route('dashboard.users.index')],
    ]" :pageName="__('USERS')" />
@endsection
@section('content')


@endsection