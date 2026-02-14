<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="fas fa-certificate text-primary me-2"></i>
                    تفاصيل اشتراك الصالون
                </h5>
            </div>
            <div class="card-body p-4">
                @if ($salon->subscription && $salon->subscription->plan)
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <div class="subscription-info">
                                <h6 class="text-muted mb-4">معلومات الباقة الحالية</h6>

                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0 text-muted" style="width: 130px;">نوع الباقة:</div>
                                    <div class="flex-grow-1">
                                        <span class="badge bg-soft-primary text-primary px-3 py-2"
                                            style="background-color: #eef2ff;">
                                            {{ $salon->subscription->plan->name }}
                                        </span>
                                        @if ($salon->subscription->status == 'trial')
                                            <span class="badge bg-warning text-dark ms-2">هدية الانضمام 🎁</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0 text-muted" style="width: 130px;">حالة الحساب:</div>
                                    <div class="flex-grow-1">
                                        @if ($salon->subscription->status == 'active')
                                            <span class="text-success"><i class="fas fa-check-circle"></i> نشط
                                                بالكامل</span>
                                        @elseif($salon->subscription->status == 'trial')
                                            <span class="text-info"><i class="fas fa-hourglass-half"></i> فترة تجريبية
                                                مجانية</span>
                                        @else
                                            <span class="text-danger"><i class="fas fa-times-circle"></i> متوقف</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0 text-muted" style="width: 130px;">تاريخ الانتهاء:</div>
                                    <div class="flex-grow-1 fw-bold text-dark">
                                        {{ $salon->subscription->end_date->format('Y-m-d') }}
                                        <small class="text-muted d-block mt-1 fw-normal">ينتهي عند الساعة 11:59
                                            مساءً</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 text-center border-start py-3">
                            <div class="days-remaining-widget">
                                <p class="text-muted mb-1">متبقي على انتهاء الصلاحية</p>
                                <div class="position-relative d-inline-block">
                                    <h2
                                        class="display-3 fw-bold mb-0 {{ $salon->remaining_days <= 3 ? 'text-danger' : 'text-primary' }}">
                                        {{ $salon->remaining_days }}
                                    </h2>
                                </div>
                                <h5 class="text-dark">يوم/أيام</h5>

                                @if ($salon->subscription->status == 'trial')
                                    <div class="alert alert-info mt-3 border-0 small">
                                        أهلاً بكِ! أنتِ الآن تستمتعين بكافة مميزات المنصة مجاناً. يمكنك الترقية لاحقاً
                                        للحفاظ على ظهور خدماتك.
                                    </div>
                                @endif

                                <a href="{{ route('front.subscriptions.create') }}"
                                    class="btn btn-primary btn-lg w-100 mt-3 shadow-sm">
                                    <i class="fas fa-rocket me-2"></i> ترقية الاشتراك الآن
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-receipt fa-4x text-light"></i>
                        </div>
                        <h5>لا يوجد اشتراك مسجل</h5>
                        <p class="text-muted">يبدو أن هناك مشكلة في إسناد الخطة، يرجى التواصل مع الدعم الفني.</p>
                        <a href="{{ route('front.subscriptions.create') }}" class="btn btn-outline-primary">تفعيل خطة
                            يدوياً</a>
                    </div>
                @endif
            </div>

            @if ($visibleHistory && $visibleHistory->count() > 0)
                <div class="card-footer bg-light border-0">
                    <button class="btn btn-link btn-sm text-decoration-none text-muted" type="button"
                        data-bs-toggle="collapse" data-bs-target="#paymentHistory">
                        <i class="fas fa-history me-1"></i> عرض سجل الاشتراكات
                    </button>
                    <div class="collapse mt-2" id="paymentHistory">
                        <div class="table-responsive">
                            <table class="table table-sm small text-muted">
                                <thead>
                                    <tr class="text-dark">
                                        <th>التاريخ</th>
                                        <th>الباقة</th>
                                        <th>المبلغ</th>
                                        <th>الطريقة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visibleHistory as $history)
                                        <tr>
                                            <td>{{ $history->created_at->format('Y-m-d') }}</td>
                                            <td>{{ $history->plan->name ?? 'باقة مخصصة' }}</td>
                                            <td>{{ $history->paid_amount }} ر.س</td>
                                            <td>
                                                {{-- منطق العرض فقط (Icons/Text) --}}
                                                @if ($history->payment_method == 'online')
                                                    <span class="text-primary"><i class="fas fa-credit-card"></i> دفع
                                                        إلكتروني</span>
                                                @elseif($history->payment_method == 'cash')
                                                    <span class="text-success"><i class="fas fa-money-bill-wave"></i>
                                                        إسناد يدوي</span>
                                                @else
                                                    <span class="text-info"><i class="fas fa-gift"></i> فترة
                                                        تجريبية</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
