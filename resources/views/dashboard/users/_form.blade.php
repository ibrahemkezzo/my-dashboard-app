{{-- Only account fields --}}
<div class="form-group">
    <label for="name">{{ __('Name') }}</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
</div>
<!-- ... other account fields ... -->