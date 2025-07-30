@extends('layouts.dashboard')


@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('dashboard.dashboard'), 'url' => route('dashboard.index')],
    ]" :pageName="__('dashboard.dashboard')" />
@endsection
@section('content')

<x-alert-message />

                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden widget-cards">
                                <div class="warning-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-navigation font-warning">
                                                    <polygon points="3 11 22 2 13 21 11 13 3 11"></polygon>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="media-body media-doller">
                                            <span class="m-0">{{ __('dashboard.salons') }}</span>
                                            <h3 class="mb-0"><span class="counter">{{$countSalons}}</span><small> </small>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden widget-cards">
                                <div class="secondary-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-box font-secondary">
                                                    <path
                                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                                    </path>
                                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                    <line x1="12" y1="22.08" x2="12"
                                                        y2="12"></line>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="media-body media-doller">
                                            <span class="m-0">{{ __('dashboard.services') }}</span>
                                            <h3 class="mb-0"> <span class="counter">{{$countServices}}</span><small></small>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden widget-cards">
                                <div class="primary-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-message-square font-primary">
                                                    <path
                                                        d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                    </path>
                                                </svg></div>
                                        </div>
                                        <div class="media-body media-doller"><span class="m-0">{{ __('dashboard.bookings') }}</span>
                                            <h3 class="mb-0"><span class="counter">{{$countBookings}}</span><small> {{ __('dashboard.this_month') }}</small></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden widget-cards">
                                <div class="danger-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-users font-danger">
                                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="9" cy="7" r="4"></circle>
                                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                </svg></div>
                                        </div>
                                        <div class="media-body media-doller"><span class="m-0">{{ __('dashboard.users') }}</span>
                                            <h3 class="mb-0"> <span class="counter">{{$countUsers}}</span><small></small></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 xl-100">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__('dashboard.most_used')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="user-status table-responsive latest-order-table">
                                        <table class="table table-bordernone">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{__('dashboard.id')}}</th>
                                                    <th scope="col">{{__('dashboard.name')}}</th>
                                                    <th scope="col">{{__('dashboard.city')}}</th>
                                                    <th scope="col">{{__('dashboard.bookings_count')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                             @foreach ($users as $user)

                                             <tr>
                                                 <td>{{$user->id}}</td>
                                                 <td class="digits">{{$user->name}}</td>
                                                 <td class="digits">{{$user->city->name ?? ''}}</td>
                                                 <td class="font-primary">{{$user->bookings_count}}</td>
                                             </tr>
                                             @endforeach
                                            </tbody>
                                        </table>
                                        <a href="{{route('dashboard.users.index')}}" class="btn btn-primary mt-4">{{__('dashboard.view_all_users')}}</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 xl-100">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__('dashboard.popular_salons')}}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="user-status table-responsive latest-order-table">
                                        <table class="table table-bordernone">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{__('dashboard.id')}}</th>
                                                    <th scope="col">{{__('dashboard.name')}}</th>
                                                    <th scope="col">{{__('dashboard.owner')}}</th>
                                                    <th scope="col">{{__('dashboard.bookings_count')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($salons as $salon)

                                                <tr>
                                                    <td>{{$salon->id}}</td>
                                                    <td class="digits">{{$salon->name}}</td>
                                                    <td class="digits ">{{$salon->owner->name}}</td>
                                                    <td class="font-secondary">{{$salon->bookings_count}}</td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        <a href="{{route('dashboard.salons.index')}}" class="btn btn-primary mt-4">{{__('dashboard.view_all_salons')}}</a>
                                    </div>

                                </div>
                            </div>
                        </div>



                    </div>
                </div>
                <!-- Container-fluid Ends-->

@endsection
