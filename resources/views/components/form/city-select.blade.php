<select name="{{ $name }}" id="{{ $name }}" class="{{ $class ?? 'form-select' }}">
    <option value="">{{ __('dashboard.select_city') }}</option>
    @foreach($cities as $city)
        <option value="{{ $city->id }}" {{ (string)$city->id === (string)$selected ? 'selected' : '' }}>
            {{ $city->name }}
        </option>
    @endforeach
</select>