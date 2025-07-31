<div class="row">
    <div class="col-md-4">
        <div class="card p-0">
            <div style="position:relative;">
                @if ($salon->cover_image_url)
                    <div style="height:120px;background:url('{{ $salon->cover_image_url }}') center center/cover no-repeat;border-top-left-radius:.5rem;border-top-right-radius:.5rem;"></div>
                @else
                    <div style="height:120px;background:#e9ecef;border-top-left-radius:.5rem;border-top-right-radius:.5rem;"></div>
                @endif
                <div style="position:absolute;left:50%;bottom:-50px;transform:translateX(-50%);">
                    @if ($salon->logo_url)
                        <img src="{{ $salon->logo_url }}" alt="logo" style="width:100px;height:100px;object-fit:cover;border-radius:50%;border:4px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                    @else
                        <div style="width:100px;height:100px;background:#f0f0f0;border-radius:50%;display:flex;align-items:center;justify-content:center;border:4px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                            <i class="fa fa-building fa-2x text-muted"></i>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body text-center" style="margin-top:60px;">
                <h4 class="mt-2">{{ $salon->name }}</h4>
                <p class="text-muted">{{ $salon->description }}</p>
                <div class="mb-3">
                    @if ($salon->status)
                        <span class="badge bg-success">نشط</span>
                    @else
                        <span class="badge bg-danger">غير نشط</span>
                    @endif
                </div>
                <div class="d-flex justify-content-center gap-2">
                    <a href="#info-edit" class="btn btn-warning mb-3" data-bs-toggle="collapse">
                        <i class="fa fa-edit"></i> تعديل
                    </a>
                    <form action="#" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من حذف الصالون؟')">
                            <i class="fa fa-trash"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>تفاصيل الصالون</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>المالك:</strong> {{ $salon->owner->name }}</p>
                        <p><strong>المدينة:</strong> {{ $salon->city->name }}</p>
                        <p><strong>الهاتف:</strong> {{ $salon->phone }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $salon->email ?? $salon->owner->email ?? 'غير متوفر' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>التقييم:</strong>
                            @if ($salon->rating > 0)
                                <span class="badge bg-warning">{{ $salon->rating }}/5</span>
                            @else
                                <span class="text-muted">لا يوجد تقييم</span>
                            @endif
                        </p>
                        <p><strong>العنوان:</strong> {{ $salon->address }}</p>
                        <p><strong>تاريخ الإنشاء:</strong> {{ $salon->created_at->format('Y-m-d') }}</p>
                    </div>
                </div>
                @if ($salon->working_hours)
                    <div class="mt-3">
                        <h6>ساعات العمل</h6>
                        <div class="row">
                            @foreach ($salon->working_hours as $day => $times)
                                <div class="col-md-6">
                                    <strong>{{ __('dashboard.' . $day) }}:</strong>
                                    @if (isset($times['closed']) && $times['closed'])
                                        <span class="badge bg-primary me-2">مغلق</span>
                                    @else
                                        @php
                                            try {
                                                $open = \Carbon\Carbon::createFromFormat('H:i', $times['open']);
                                                $close = \Carbon\Carbon::createFromFormat('H:i', $times['close']);
                                                $formattedTime = 'من ' . $open->format('h:i') . ' ' . ($open->format('A') == 'AM' ? 'صباحًا' : 'مساءً') . ' إلى ' . $close->format('h:i') . ' ' . ($close->format('A') == 'AM' ? 'صباحًا' : 'مساءً');
                                            } catch (\Exception $e) {
                                                $formattedTime = 'وقت غير صالح';
                                            }
                                        @endphp
                                        {{ $formattedTime }}
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="collapse mt-3" id="info-edit">
            @include('frontend.salons.manager._form_info', ['salon' => $salon])
        </div>
    </div>
</div>
