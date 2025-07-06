@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.user'), 'url' => route('dashboard.users.index')],
        ['label' => __('dashboard.create'), 'url' => route('dashboard.users.create')],
    ]" :pageName="__('dashboard.create_user')" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card tab2-card">
                <div class="card-body">
                    <h4>{{ __('dashboard.create_user') }}</h4>
                    @include('dashboard.users._form', ['user' => null, 'roles' => $roles])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection