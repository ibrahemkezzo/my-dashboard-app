    <div class="auth-container hairdresser-auth">
        <div class="container">
            <div class="row justify-content-center py-5">
                <div class="col-lg-8 col-md-10">
                    <div class="auth-card large">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold auth-title">انضمي كخبيرة تجميل - الخطوة الثانية</h2>
                            <p class="text-muted">أضيفي الخدمات التي تقدمينها والمميزات المتوفرة في صالونك</p>
                        </div>


                        <!-- Services -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-list me-2"></i>الخدمات المقدمة
                            </h5>

                            <div id="servicesContainer">
                                {{-- <div class="service-item">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-semibold">الخدمة</label>
                                            <select name="salon_services[0][service_id]"
                                                class="form-control main-service-select" data-index="0" required>
                                                <option value="">اختر الخدمة</option>
                                                ${allServices.map(s => `<option value="${s.id}">${s.name}</option>`).join('')}
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label fw-semibold">الخدمة الفرعية</label>
                                            <select name="salon_services[0][sub_service_id]"
                                                class="form-control sub-service-select" data-index="0" required>
                                                <option value="">اختر الخدمة الفرعية</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label fw-semibold">السعر (ريال)</label>
                                            <input type="number" step="0.01" class="form-control service-price"
                                                name="salon_services[0][price]" placeholder="150" required>
                                        </div>
                                        <div class="col-md-2 mb-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-danger remove-service"
                                                style="display: none;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-semibold">الحالة</label>
                                            <select class="form-control" name="salon_services[0][status]">
                                                <option value="1">مفعل</option>
                                                <option value="0">غير مفعل</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-semibold">صور الخدمة</label>
                                            <input type="file" class="form-control"
                                                name="salon_services[0][images][]" multiple accept="image/*">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">وصف الخدمة</label>
                                        <textarea class="form-control service-description" name="salon_services[0][description]" rows="2"
                                            placeholder="اكتبي وصفاً مختصراً للخدمة..." required></textarea>
                                    </div>
                                </div> --}}
                            </div>

                            <button type="button" class="btn btn-outline-primary" id="addService">
                                <i class="fas fa-plus me-2"></i>إضافة خدمة
                            </button>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-secondary btn-lg w-100" id="backStepBtn">
                                    <i class="fas fa-arrow-right me-2"></i>رجوع
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-check me-2"></i>تسجيل
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/auth.css') }}">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('frontend/assets/js/auth.js') }}"></script>
        <script>
            let serviceIndex = 0;
            const allServices = @json(
                $allServices->map(function ($s) {
                    return ['id' => $s->id, 'name' => $s->name];
                }));
            const subServices = @json(
                $subServices->map(function ($ss) {
                    return ['id' => $ss->id, 'name' => $ss->name, 'service_id' => $ss->service_id];
                }));

            function addNewService() {
                const servicesContainer = document.getElementById('servicesContainer');
                const serviceCount = servicesContainer.children.length;

                if (serviceCount >= 10) {
                    showMessage('لا يمكن إضافة أكثر من 10 خدمات', 'warning');
                    return;
                }

                const newService = document.createElement('div');
                newService.className = 'service-item';
                newService.innerHTML = `
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">الخدمة</label>
                        <select name="salon_services[${serviceIndex}][service_id]" class="form-control main-service-select" data-index="${serviceIndex}" required>
                            <option value="">اختر الخدمة</option>
                            ${allServices.map(s => `<option value="${s.id}">${s.name}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">الخدمة الفرعية</label>
                        <select name="salon_services[${serviceIndex}][sub_service_id]" class="form-control sub-service-select" data-index="${serviceIndex}" required>
                            <option value="">اختر الخدمة الفرعية</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">السعر (ريال)</label>
                        <input type="number" step="0.01" class="form-control service-price" name="salon_services[${serviceIndex}][price]" placeholder="200" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">المدة </label>
                        <input type="number" step="0.01" class="form-control service-price" name="salon_services[${serviceIndex}][duration]" placeholder="200" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">الحالة</label>
                        <select class="form-control" name="salon_services[${serviceIndex}][status]">
                            <option value="1">مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">وصف الخدمة</label>
                        <textarea class="form-control service-description" name="salon_services[${serviceIndex}][special_notes]" rows="2" placeholder="اكتبي وصفاً مختصراً للخدمة..." required></textarea>
                    </div>
                     <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger remove-service">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

                servicesContainer.appendChild(newService);

                // Attach remove button event listener
                newService.querySelector('.remove-service').addEventListener('click', function() {
                    removeService(this);
                });

                // Attach service change event
                attachServiceChange(newService, serviceIndex);

                // Show remove button for all services when there's more than one
                updateRemoveButtons();

                // Animate the new service
                newService.style.opacity = '0';
                newService.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    newService.style.transition = 'all 0.3s ease';
                    newService.style.opacity = '1';
                    newService.style.transform = 'translateY(0)';
                }, 10);

                serviceIndex++;
            }

            function removeService(button) {
                const serviceItem = button.closest('.service-item');
                const servicesContainer = document.getElementById('servicesContainer');

                if (servicesContainer.children.length <= 1) {
                    showMessage('يجب أن يكون لديك خدمة واحدة على الأقل', 'warning');
                    return;
                }

                serviceItem.style.transition = 'all 0.3s ease';
                serviceItem.style.opacity = '0';
                serviceItem.style.transform = 'translateX(-100%)';

                setTimeout(() => {
                    serviceItem.remove();
                    updateRemoveButtons();
                }, 300);
            }

            function updateRemoveButtons() {
                const servicesContainer = document.getElementById('servicesContainer');
                const removeButtons = servicesContainer.querySelectorAll('.remove-service');

                if (servicesContainer.children.length > 1) {
                    removeButtons.forEach(button => {
                        button.style.display = 'block';
                    });
                } else {
                    removeButtons.forEach(button => {
                        button.style.display = 'none';
                    });
                }
            }

            function attachServiceChange(row, index) {
                const mainSelect = row.querySelector('.main-service-select');
                const subSelect = row.querySelector('.sub-service-select');
                mainSelect.addEventListener('change', function() {
                    const serviceId = this.value;
                    subSelect.innerHTML = `<option value="">اختر الخدمة الفرعية</option>`;
                    subServices.forEach(function(ss) {
                        if (ss.service_id == serviceId) {
                            subSelect.innerHTML += `<option value="${ss.id}">${ss.name}</option>`;
                        }
                    });
                });
            }

        </script>
    @endpush
