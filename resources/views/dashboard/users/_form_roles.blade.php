@php
    $isEdit = isset($user) && $user->exists;
@endphp

<form method="POST" action="{{ $isEdit ? route('dashboard.users.update', $user) : route('dashboard.users.store') }}">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ ($activeTab ?? 'info') === 'info' ? 'active' : '' }}" href="#info" data-bs-toggle="tab">
                {{ __('Personal Info') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($activeTab ?? 'info') === 'roles' ? 'active' : '' }}" href="#roles" data-bs-toggle="tab">
                {{ __('Roles') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane {{ ($activeTab ?? 'info') === 'info' ? 'active show' : '' }}" id="info">
            {{-- Account fields --}}
            <div class="form-group mb-3">
                <label for="name">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mb-3">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mb-3">
                <label for="password">{{ __('Password') }}</label>
                <input type="password" name="password" id="password" class="form-control" {{ $isEdit ? '' : 'required' }}>
                @if($isEdit)
                    <small class="form-text text-muted">{{ __('Leave blank to keep current password') }}</small>
                @endif
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mb-3">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" {{ $isEdit ? '' : 'required' }}>
                @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="tab-pane {{ ($activeTab ?? 'info') === 'roles' ? 'active show' : '' }}" id="roles">
            {{-- Roles selection --}}
            <div class="form-group mb-3">
                <label for="roles">{{ __('Roles') }}</label>
                <select name="roles[]" id="roles" class="form-control" multiple required>
                    @foreach($roles as $id => $role)
                        <option value="{{ $role }}"
                            {{ in_array($role, old('roles', isset($user) ? $user->roles->pluck('name')->toArray() : [])) ? 'selected' : '' }}>
                            {{ $role }}
                        </option>
                    @endforeach
                </select>
                @error('roles') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">
        {{ $isEdit ? __('Update User') : __('Create User') }}
    </button>
</form>