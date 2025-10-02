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
                            <!-- سيتم إضافة عناصر الخدمة ديناميكيًا هنا -->
                        </div>

                        <button type="button" class="btn btn-outline-primary" id="addService">
                            <i class="fas fa-plus me-2"></i>إضافة خدمة
                        </button>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100" id="submitServices">
                                <i class="fas fa-check me-2"></i>تسجيل
                            </button>
                        </div>
                    </div>

                    <!-- Flash Messages -->
                    <div class="flash-message-container mt-4">
                        <x-alert-message />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/auth.css?v='.config('app.version')) }}">
    <style>
        .flash-message-container {
            position: relative;
            width: 100%;
            min-height: 50px;
        }
        .alert {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            opacity: 0;
            transition: all 0.5s ease;
            z-index: 9999;
            max-width: 600px;
            width: 90%;
        }
        .alert.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        .is-invalid {
            border-color: #dc3545 !important;
        }
        .invalid-feedback {
            display: none;
            color: #dc3545;
            font-size: 0.875em;
        }
        .is-invalid ~ .invalid-feedback {
            display: block;
        }
    </style>
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

        // دالة لعرض رسائل التنبيه
        function showMessage(message, type) {
            const alertContainer = document.createElement('div');
            alertContainer.className = `alert alert-${type} alert-dismissible fade`;
            alertContainer.role = 'alert';
            alertContainer.style.position = 'fixed';
            alertContainer.style.bottom = '20px';
            alertContainer.style.left = '50%';
            alertContainer.style.transform = 'translateX(-50%) translateY(20px)';
            alertContainer.style.opacity = '0';
            alertContainer.style.transition = 'all 0.5s ease';
            alertContainer.style.zIndex = '9999';
            alertContainer.style.maxWidth = '600px';
            alertContainer.style.width = '90%';
            alertContainer.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(alertContainer);

            setTimeout(() => {
                alertContainer.classList.add('show');
                alertContainer.style.opacity = '1';
                alertContainer.style.transform = 'translateX(-50%) translateY(0)';
            }, 10);

            setTimeout(() => {
                alertContainer.style.opacity = '0';
                alertContainer.style.transform = 'translateX(-50%) translateY(20px)';
                setTimeout(() => {
                    alertContainer.remove();
                }, 500);
            }, 5000);
        }

        // دالة للتحقق من تكرار الخدمة الفرعية
        function checkDuplicateSubService(subServiceId, currentIndex) {
            const subServiceSelects = document.querySelectorAll('.sub-service-select');
            for (let select of subServiceSelects) {
                const index = select.getAttribute('data-index');
                if (index !== currentIndex && select.value === subServiceId && subServiceId !== '') {
                    return true;
                }
            }
            return false;
        }

        // دالة للتحقق من السعر وأقصى سعر
        function validatePriceMaxPrice(priceInput, maxPriceInput) {
            const price = parseFloat(priceInput.value);
            const maxPrice = parseFloat(maxPriceInput.value);
            const submitButton = document.getElementById('submitServices');

            if (price && maxPrice && price > maxPrice) {
                priceInput.classList.add('is-invalid');
                maxPriceInput.classList.add('is-invalid');
                maxPriceInput.nextElementSibling.textContent = 'يجب أن يكون اقصى سعر أكبر من أو يساوي السعر';
                submitButton.disabled = true;
                // showMessage('يجب أن يكون السعر أكبر من أو يساوي أقصى سعر', 'danger');
                return false;
            } else {
                priceInput.classList.remove('is-invalid');
                maxPriceInput.classList.remove('is-invalid');
                priceInput.nextElementSibling.textContent = '';
                submitButton.disabled = false;
                return true;
            }
        }

        function addNewService() {
            const servicesContainer = document.getElementById('servicesContainer');
            const serviceCount = servicesContainer.children.length;

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
                        <input type="number" step="0.01" class="form-control service-price" name="salon_services[${serviceIndex}][price]" placeholder="min price" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">أقصى سعر (ريال)</label>
                        <input type="number" step="0.01" class="form-control service-price" name="salon_services[${serviceIndex}][max_price]" placeholder="max price" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">المدة</label>
                        <input type="number" step="0.01" class="form-control service-price" name="salon_services[${serviceIndex}][duration]" placeholder="..." required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">الحالة</label>
                        <select class="form-control" name="salon_services[${serviceIndex}][status]">
                            <option value="1">مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-danger remove-service">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            servicesContainer.appendChild(newService);

            // إضافة مستمع حدث زر الحذف
            newService.querySelector('.remove-service').addEventListener('click', function() {
                removeService(this);
            });

            // إضافة مستمع حدث تغيير الخدمة
            attachServiceChange(newService, serviceIndex);

            // إضافة مستمع للتحقق من تكرار الخدمة الفرعية
            const subSelect = newService.querySelector('.sub-service-select');
            subSelect.addEventListener('change', function() {
                const selectedSubServiceId = this.value;
                const currentIndex = this.getAttribute('data-index');
                if (checkDuplicateSubService(selectedSubServiceId, currentIndex)) {
                    showMessage('هذه الخدمة الفرعية مختارة بالفعل. اختر خدمة أخرى.', 'warning');
                    this.value = '';
                }
            });

            // إضافة مستمع للتحقق من السعر وأقصى سعر
            const priceInput = newService.querySelector(`input[name="salon_services[${serviceIndex}][price]"]`);
            const maxPriceInput = newService.querySelector(`input[name="salon_services[${serviceIndex}][max_price]"]`);
            [priceInput, maxPriceInput].forEach(input => {
                input.addEventListener('input', () => {
                    validatePriceMaxPrice(priceInput, maxPriceInput);
                });
            });

            // تحديث أزرار الحذف
            updateRemoveButtons();

            // إضافة التحريك
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

        // إضافة أول خدمة عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', () => {
            addNewService();
        });

        // إضافة مستمع زر إضافة الخدمة
        document.getElementById('addService').addEventListener('click', addNewService);
    </script>
@endpush
