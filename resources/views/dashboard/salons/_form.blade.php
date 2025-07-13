<div class="row mb-3">
    <div class="col-md-6">
        <label for="name" class="form-label">{{ __('dashboard.name') }}</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $salon->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="owner_id" class="form-label">{{ __('dashboard.owner') }}</label>
        <select name="owner_id" id="owner_id" class="form-control" required>
            <option value="">{{ __('dashboard.choose_owner') }}</option>
            @foreach($owners as $owner)
                <option value="{{ $owner->id }}" {{ old('owner_id', $salon->owner_id ?? '') == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label for="description" class="form-label">{{ __('dashboard.description') }}</label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $salon->description ?? '') }}</textarea>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="address" class="form-label">{{ __('dashboard.address') }}</label>
        <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $salon->address ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="city_id" class="form-label">{{ __('dashboard.city') }}</label>
        <x-form.city-select name="city_id" :selected="$salon->city_id" class="form-control"/>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label for="phone" class="form-label">{{ __('dashboard.phone') }}</label>
        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $salon->phone ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="email" class="form-label">{{ __('dashboard.email') }}</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $salon->email ?? '') }}">
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="status" class="form-label">{{ __('dashboard.status') }}</label>
        <select name="status" id="status" class="form-control">
            <option value="1" {{ old('status', $salon->status ?? 1) == 1 ? 'selected' : '' }}>{{ __('dashboard.active') }}</option>
            <option value="0" {{ old('status', $salon->status ?? 1) == 0 ? 'selected' : '' }}>{{ __('dashboard.inactive') }}</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="logo" class="form-label">{{ __('dashboard.logo') }}</label>
        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
        @if(!empty($salon) && $salon->logo)
            <img src="{{ asset('storage/'.$salon->logo) }}" alt="logo" style="width:40px;height:40px;object-fit:cover;border-radius:50%;" class="mt-2">
        @endif
    </div>
    <div class="col-md-4">
        <label for="cover_image" class="form-label">{{ __('dashboard.cover_image') }}</label>
        <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
        @if(!empty($salon) && $salon->cover_image)
            <img src="{{ asset('storage/'.$salon->cover_image) }}" alt="cover" style="width:40px;height:40px;object-fit:cover;" class="mt-2">
        @endif
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label class="form-label">{{ __('dashboard.working_hours') }}</label>
        <div class="row g-2">
            @php
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                $workingHours = old('working_hours', $salon->working_hours ?? []);
            @endphp
            @foreach($days as $day)
                <div class="col-md-6">
                    <label for="working_hours_{{ $day }}" class="form-label">{{ ucfirst($day) }}</label>
                    <input type="text" class="form-control" id="working_hours_{{ $day }}" name="working_hours[{{ $day }}]" value="{{ $workingHours[$day] ?? '' }}" placeholder="9:00 AM - 6:00 PM">
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label class="form-label">{{ __('dashboard.social_links') }}</label>
        <div class="row g-2">
            <div class="col-md-4">
                <input type="url" name="social_links[facebook]" value="{{ old('social_links.facebook', $salon->social_links['facebook'] ?? '') }}" class="form-control" placeholder="Facebook URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[twitter]" value="{{ old('social_links.twitter', $salon->social_links['twitter'] ?? '') }}" class="form-control" placeholder="Twitter URL">
            </div>
            <div class="col-md-4">
                <input type="url" name="social_links[instagram]" value="{{ old('social_links.instagram', $salon->social_links['instagram'] ?? '') }}" class="form-control" placeholder="Instagram URL">
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label class="form-label">{{ __('dashboard.seo_meta') }}</label>
        <input type="text" class="form-control mb-2" name="seo_meta[title]" value="{{ old('seo_meta.title', $salon->seo_meta['title'] ?? '') }}" placeholder="{{ __('dashboard.seo_title') }}">
        <textarea class="form-control" name="seo_meta[description]" placeholder="{{ __('dashboard.seo_description') }}">{{ old('seo_meta.description', $salon->seo_meta['description'] ?? '') }}</textarea>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-12">
        <label class="form-label">{{ __('dashboard.salon_services') }}</label>
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
                        @php
                            $pivot = isset($salon) ? $salon->subServices->firstWhere('id', $serviceData['sub_service_id'])?->pivot : null;
                        @endphp
                        @if($pivot && $pivot->media)
                            <div class="row mt-2">
                                @foreach($pivot->media as $media)
                                    <div class="col-md-6 text-center mb-1">
                                        <img src="{{ asset('storage/'.$media->path) }}" alt="service-img" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                                        <form action="{{ route('dashboard.media.destroy', $media->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger mt-1"><i class="fa fa-trash"></i></button>
                                        </form>
                                        <form action="{{ route('dashboard.media.update', $media->id) }}" method="POST" enctype="multipart/form-data" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="file" name="file" accept="image/*" style="width:50px;display:inline-block;">
                                            <button type="submit" class="btn btn-xs btn-primary mt-1"><i class="fa fa-upload"></i></button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-service-row" onclick="removeServiceRow(this)"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-outline-primary mt-2" id="add-service-row"><i class="fa fa-plus"></i> {{ __('dashboard.add_service') }}</button>
    </div>
</div>

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
                <label class="form-label">{{ __('dashboard.materials_used') }}</label>
                <textarea class="form-control" rows="1" name="salon_services[${serviceIndex}][materials_used]"></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ __('dashboard.requirements') }}</label>
                <textarea class="form-control" rows="1" name="salon_services[${serviceIndex}][requirements]"></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">{{ __('dashboard.special_notes') }}</label>
                <textarea class="form-control" rows="1" name="salon_services[${serviceIndex}][special_notes]"></textarea>
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
            subSelect.innerHTML = `<option value="">{{ __('dashboard.choose_sub_service') }}</option>`;
            subServices.forEach(function(ss) {
                if (ss.service_id == serviceId) {
                    subSelect.innerHTML += `<option value="${ss.id}">${ss.name}</option>`;
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

<button type="submit" class="btn btn-primary">{{ $submitText }}</button>
<a href="{{ route('dashboard.salons.index') }}" class="btn btn-outline-primary">{{ __('dashboard.cancel') }}</a>