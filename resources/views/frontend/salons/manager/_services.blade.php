<div class="mb-4">
    <h5>إضافة خدمة جديدة</h5>
    <form action="{{ route('front.profile.salon.manager.addService') }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-end" id="addServiceForm">
        @csrf
        <div class="col-md-3">
            <label class="form-label">الخدمة الرئيسية</label>
            <select name="service_id" id="mainServiceSelect" class="form-control" required>
                <option value="">اختر الخدمة</option>
                @foreach(App\Models\Service::all() as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">الخدمة الفرعية</label>
            <select name="sub_service_id" id="subServiceSelect" class="form-control" required>
                <option value="">اختر الخدمة الفرعية</option>
                @foreach(App\Models\SubService::all() as $subService)
                    <option value="{{ $subService->id }}" data-service="{{ $subService->service_id }}">{{ $subService->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">السعر (ريال)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">المدة (دقيقة)</label>
            <input type="number" name="duration" class="form-control" required>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">إضافة</button>
        </div>
    </form>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainServiceSelect = document.getElementById('mainServiceSelect');
        const subServiceSelect = document.getElementById('subServiceSelect');
        const allSubOptions = Array.from(subServiceSelect.querySelectorAll('option[data-service]'));

        function updateSubServices() {
            const selectedService = mainServiceSelect.value;
            subServiceSelect.innerHTML = '<option value="">اختر الخدمة الفرعية</option>';
            allSubOptions.forEach(function(option) {
                if (!selectedService || option.getAttribute('data-service') === selectedService) {
                    subServiceSelect.appendChild(option.cloneNode(true));
                }
            });
        }

        mainServiceSelect.addEventListener('change', updateSubServices);
        // Initialize on page load
        updateSubServices();
    });
</script>
@endpush
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>الخدمة الرئيسية</th>
                <th>الخدمة الفرعية</th>
                <th>السعر</th>
                <th>المدة</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->service->name ?? '-' }}</td>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->pivot->price }}</td>
                    <td>{{ $service->pivot->duration }}</td>
                    <td>{{ $service->pivot->status ? 'مفعلة' : 'غير مفعلة' }}</td>
                    <td>
                        <!-- View Button -->
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewServiceModal{{ $service->pivot->id }}">
                            <i class="fa fa-eye"></i>
                        </button>
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->pivot->id }}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <!-- Delete Button -->
                        <form action="{{ route('front.profile.salon.manager.services.delete', $service->pivot->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف الخدمة؟')"><i class="fa fa-trash"></i></button>
                        </form>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewServiceModal{{ $service->pivot->id }}" tabindex="-1" aria-labelledby="viewServiceModalLabel{{ $service->pivot->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewServiceModalLabel{{ $service->pivot->id }}">تفاصيل الخدمة</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>الاسم: {{ $service->name }}</h6>
                                        <p>الخدمة الرئيسية: {{ $service->service->name ?? '-' }}</p>
                                        <p>السعر: {{ $service->pivot->price }} ريال</p>
                                        <p>المدة: {{ $service->pivot->duration }} دقيقة</p>
                                        <p>الحالة: {{ $service->pivot->status ? 'مفعلة' : 'غير مفعلة' }}</p>
                                        <p>الوصف: {{ $service->pivot->special_notes }}</p>
                                        <h6>صور الخدمة:</h6>
                                        <div class="row">
                                            @if($service->pivot->media && $service->pivot->media->count() > 0)
                                                @foreach($service->pivot->media as $media)
                                                    <div class="col-md-3 mb-2">
                                                        <img src="{{ asset('storage/'.$media->path) }}" alt="service-img" style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                                                        <form action="{{ route('front.profile.salon.manager.services.images.delete', [$service->pivot->id, $media->id]) }}" method="POST" class="mt-1">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                                        </form>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-12 text-muted">لا توجد صور لهذه الخدمة.</div>
                                            @endif
                                        </div>
                                        <form action="{{ route('front.profile.salon.manager.services.images.add', $service->pivot->id) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                            @csrf
                                            <input type="file" name="images[]" multiple accept="image/*" class="form-control mb-2">
                                            <button type="submit" class="btn btn-primary btn-sm">إضافة صور</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editServiceModal{{ $service->pivot->id }}" tabindex="-1" aria-labelledby="editServiceModalLabel{{ $service->pivot->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editServiceModalLabel{{ $service->pivot->id }}">تعديل الخدمة</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('front.profile.salon.manager.services.edit', $service->pivot->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label class="form-label">السعر (ريال)</label>
                                                <input type="number" step="0.01" name="price" class="form-control" value="{{ $service->pivot->price }}" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">المدة (دقيقة)</label>
                                                <input type="number" name="duration" class="form-control" value="{{ $service->pivot->duration }}" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">الحالة</label>
                                                <select name="status" class="form-control">
                                                    <option value="1" {{ $service->pivot->status ? 'selected' : '' }}>مفعلة</option>
                                                    <option value="0" {{ !$service->pivot->status ? 'selected' : '' }}>غير مفعلة</option>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">ملاحظات/وصف</label>
                                                <textarea name="special_notes" class="form-control">{{ $service->pivot->special_notes }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> 