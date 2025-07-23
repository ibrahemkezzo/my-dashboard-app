<div id="salon-services-container">
    @php
        $oldServices = old('salon_services', isset($salon) ? $salon->subServices->map(function($ss) {
            return [
                'service_id' => $ss->service_id,
                'sub_service_id' => $ss->id,
                'price' => $ss->pivot->price,
                'duration' => $ss->pivot->duration,
                'status' => $ss->pivot->status,
                'materials_used' => $ss->pivot->materials_used,
                'requirements' => $ss->pivot->requirements,
                'special_notes' => $ss->pivot->special_notes,
            ];
        })->toArray() : []);
    @endphp
    @foreach($oldServices as $i => $serviceData)
        <div class="row mb-3 salon-service-row align-items-end">
            <div class="col-md-2">
                <label class="form-label">{{ __('dashboard.service') }}</label>
                <select name="salon_services[{{ $i }}][service_id]" class="form-control main-service-select" data-index="{{ $i }}" required>
                    <option value="">{{ __('dashboard.choose_service') }}</option>
                    @foreach($allServices as $service)
                        <option value="{{ $service->id }}" {{ $serviceData['service_id'] == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ __('dashboard.sub_service') }}</label>
                <select name="salon_services[{{ $i }}][sub_service_id]" class="form-control sub-service-select" data-index="{{ $i }}" required>
                    <option value="">{{ __('dashboard.choose_sub_service') }}</option>
                    @foreach($subServices as $ss)
                        @if($ss->service_id == $serviceData['service_id'])
                            <option value="{{ $ss->id }}" {{ $serviceData['sub_service_id'] == $ss->id ? 'selected' : '' }}>{{ $ss->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('dashboard.price') }}</label>
                <input type="number" step="0.01" class="form-control" name="salon_services[{{ $i }}][price]" value="{{ $serviceData['price'] ?? 0 }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('dashboard.duration') }} ({{ __('dashboard.minutes') }})</label>
                <input type="number" class="form-control" name="salon_services[{{ $i }}][duration]" value="{{ $serviceData['duration'] ?? 0 }}">
            </div>
            <div class="col-md-1">
                <label class="form-label">{{ __('dashboard.status') }}</label>
                <select class="form-control" name="salon_services[{{ $i }}][status]">
                    <option value="1" {{ ($serviceData['status'] ?? 1) == 1 ? 'selected' : '' }}>{{ __('dashboard.active') }}</option>
                    <option value="0" {{ ($serviceData['status'] ?? 1) == 0 ? 'selected' : '' }}>{{ __('dashboard.inactive') }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('dashboard.materials_used') }}</label>
                <textarea class="form-control" rows="1" name="salon_services[{{ $i }}][materials_used]">{{ $serviceData['materials_used'] ?? '' }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ __('dashboard.requirements') }}</label>
                <textarea class="form-control" rows="1" name="salon_services[{{ $i }}][requirements]">{{ $serviceData['requirements'] ?? '' }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ __('dashboard.special_notes') }}</label>
                <textarea class="form-control" rows="1" name="salon_services[{{ $i }}][special_notes]">{{ $serviceData['special_notes'] ?? '' }}</textarea>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('dashboard.sub_service_images') }}</label>
                <input type="file" class="form-control" name="salon_services[{{ $i }}][images][]" multiple accept="image/*">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-service-row" onclick="removeServiceRow(this)"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    @endforeach
</div>
<button type="button" class="btn btn-outline-primary mt-2" id="add-service-row"><i class="fa fa-plus"></i> {{ __('dashboard.add_service') }}</button>
<button type="submit" class="btn btn-primary">{{ $saveText ?? __('Save') }}</button>

@push('scripts')
<script>
    let serviceIndex = {{ count($oldServices) }};
    const allServices = @json($allServices->map(function($s){ return ['id'=>$s->id,'name'=>$s->name]; }));
    const subServices = @json($subServices->map(function($ss){ return ['id'=>$ss->id,'name'=>$ss->name,'service_id'=>$ss->service_id]; }));

    document.getElementById('add-service-row').addEventListener('click', function() {
        addServiceRow();
    });

    function addServiceRow() {
        const container = document.getElementById('salon-services-container');
        let row = document.createElement('div');
        row.className = 'row mb-3 salon-service-row align-items-end';
        row.innerHTML = `
            <div class="col-md-2">
                <label class="form-label">{{ __('dashboard.service') }}</label>
                <select name="salon_services[${serviceIndex}][service_id]" class="form-control main-service-select" data-index="${serviceIndex}" required>
                    <option value="">{{ __('dashboard.choose_service') }}</option>
                    ${allServices.map(s => `<option value="${s.id}">${s.name}</option>`).join('')}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ __('dashboard.sub_service') }}</label>
                <select name="salon_services[${serviceIndex}][sub_service_id]" class="form-control sub-service-select" data-index="${serviceIndex}" required>
                    <option value="">{{ __('dashboard.choose_sub_service') }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('dashboard.price') }}</label>
                <input type="number" step="0.01" class="form-control" name="salon_services[${serviceIndex}][price]" value="0">
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('dashboard.duration') }} ({{ __('dashboard.minutes') }})</label>
                <input type="number" class="form-control" name="salon_services[${serviceIndex}][duration]" value="0">
            </div>
            <div class="col-md-1">
                <label class="form-label">{{ __('dashboard.status') }}</label>
                <select class="form-control" name="salon_services[${serviceIndex}][status]">
                    <option value="1">{{ __('dashboard.active') }}</option>
                    <option value="0">{{ __('dashboard.inactive') }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ __('dashboard.sub_service_images') }}</label>
                <input type="file" class="form-control" name="salon_services[${serviceIndex}][images][]" multiple accept="image/*">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-service-row" onclick="removeServiceRow(this)"><i class="fa fa-trash"></i></button>
            </div>
        `;
        container.appendChild(row);
        attachServiceChange(row, serviceIndex);
        serviceIndex++;
    }

    function removeServiceRow(btn) {
        btn.closest('.salon-service-row').remove();
    }

    function attachServiceChange(row, index) {
        const mainSelect = row.querySelector('.main-service-select');
        const subSelect = row.querySelector('.sub-service-select');
        mainSelect.addEventListener('change', function() {
            const serviceId = this.value;
            subSelect.innerHTML = `<option value=\"\">{{ __('dashboard.choose_sub_service') }}</option>`;
            subServices.forEach(function(ss) {
                if (ss.service_id == serviceId) {
                    subSelect.innerHTML += `<option value=\"${ss.id}\">${ss.name}</option>`;
                }
            });
        });
    }

    // Attach change event for pre-populated rows
    document.querySelectorAll('.main-service-select').forEach(function(mainSelect) {
        const index = mainSelect.getAttribute('data-index');
        const row = mainSelect.closest('.salon-service-row');
        attachServiceChange(row, index);
    });
</script>
@endpush