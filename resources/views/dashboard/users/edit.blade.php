@extends('layouts.dashboard')

@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.user'), 'url' => route('dashboard.users.index')],
        ['label' => __('dashboard.edit'), 'url' => route('dashboard.users.edit',$user->id)],
    ]" :pageName="__('dashboard.edit_user')" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card tab2-card">
                <div class="card-body">
                    <h4>{{ __('dashboard.edit_user') }}</h4>
                    @include('dashboard.users._form', [
                        'user' => $user, 
                        'roles' => $roles, 
                        'activeTab' => $activeTab ?? 'info'
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection