<div class="booking-summary mb-4">
    <div class="row">
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h4>{{ $statistics['total'] }}</h4>
                    <p class="mb-0">إجمالي الحجوزات</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h4>{{ $statistics['pending'] }}</h4>
                    <p class="mb-0">بانتظار التأكيد</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-info text-white">
                <div style="padding-right: 7%; padding-left: 7%;" class="card-body text-center">
                    <h4>{{ $statistics['salon_confirmed'] }}</h4>
                    <p class="mb-0">تم تأكيدها من الصالون</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-success text-white">
                <div style="padding-right: 7%; padding-left: 7%;" class="card-body text-center">
                    <h4>{{ $statistics['user_confirmed'] }}</h4>
                    <p class="mb-0">تم تأكيدها من العميل</p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h4>{{ $statistics['rejected'] + $statistics['cancelled'] }}</h4>
                    <p class="mb-0"> ملغية أو مرفوضة </p>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card bg-info text-white ">
                <div class="card-body text-center">
                    <h4>{{ $statistics['completed'] }}</h4>
                    <p class="mb-0">{{ __('dashboard.completed_bookings') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>رقم الحجز</th>
                <th>العميل</th>
                <th>الخدمة</th>
                <th>التاريخ</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_number }}</td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->salonSubService->subService->name ?? '-' }}</td>
                    <td>{{ $booking->preferred_datetime->format('Y-m-d H:i') }}</td>
                    <td><span class="badge {{ $booking->status_badge_class }}">{{ $booking->status_text }}</span></td>
                    <td>
                        @if($booking->canBeConfirmedBySalon())
                            <form action="{{ route('front.profile.salon.manager.bookingAction', $booking) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="action" value="confirm">
                                <button type="submit" class="btn btn-success btn-sm">تأكيد</button>
                            </form>
                        @endif
                        @if($booking->canBeCompleted())
                            <form action="{{ route('front.profile.salon.manager.bookingAction', $booking) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="action" value="completed">
                                <button type="submit" class="btn btn-success btn-sm">مكتمل</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if($booking->canBeRejected())
                            <form action="{{ route('front.profile.salon.manager.bookingAction', $booking) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                <input type="text" name="rejection_reason" placeholder="سبب الرفض" class="form-control form-control-sm d-inline-block w-auto" required>
                                <button type="submit" class="btn btn-danger btn-sm">رفض</button>
                            </form>
                        @endif
                        @if($booking->canBeCancelled())
                            <form action="{{ route('front.profile.salon.manager.bookingAction', $booking) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="action" value="cancel">
                                <input type="text" name="cancellation_reason" placeholder="سبب الإلغاء" class="form-control form-control-sm d-inline-block w-auto" required>
                                <button type="submit" class="btn btn-secondary btn-sm">إلغاء</button>
                            </form>
                        @endif
                        <!-- Modify can be implemented as a modal or extra form if needed -->

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>