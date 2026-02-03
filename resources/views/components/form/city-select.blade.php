<select name="{{ $name }}" id="{{ $name }}" class="@error('city_id')
                                                            is-invalid
                                                            @enderror {{ $class ?? 'form-select' }}">
    <option value="">{{ __('dashboard.select_city') }}</option>
    @foreach($cities as $city)
        <option value="{{ $city->id }}"
                {{ (string)$city->id === (string)$selected ? 'selected' : '' }}
                {{ $city->is_active == 0 ? 'disabled' : '' }}>
            {{ $city->name }} {{ $city->is_active == 0 ? ' (قريبًا) ' : '' }}
        </option>
    @endforeach
</select>
