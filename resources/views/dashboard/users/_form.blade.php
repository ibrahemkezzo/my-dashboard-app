@php
    $isEdit = isset($user) && $user->exists;
    $activeTab = $activeTab ?? 'info';
@endphp

<form method="POST" action="{{ $isEdit ? route('dashboard.users.update', $user) : route('dashboard.users.store') }}">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'info' ? 'active' : '' }}" href="#info" data-bs-toggle="tab">
                {{ __('dashboard.personal_info') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'roles' ? 'active' : '' }}" href="#roles" data-bs-toggle="tab">
                {{ __('dashboard.roles') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane {{ $activeTab === 'info' ? 'active show' : '' }}" id="info">
            {{-- Account fields --}}
            <div class="form-group mb-3">
                <label for="name">{{ __('dashboard.name') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mb-3">
                <label for="email">{{ __('dashboard.email') }}</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mb-3">
                <label for="phone_number">{{ __('dashboard.phone_number') }}</label>
                <input type="phone_number" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number ?? '') }}" required>
                @error('phone_number') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label for="city">{{ __('dashboard.city') }}</label>
                {{-- <select name="city_id" class="form-select @error('city_id') is-invalid @enderror" id="city" required>
                  <option value="">اختر المدينة</option>
                    <option value="1">الرياض</option>
                    <option value="jeddah">جدة</option>
                    <option value="dammam">الدمام</option>
                    <option value="mecca">مكة المكرمة</option>
                    <option value="medina">المدينة المنورة</option>
                    <option value="taif">الطائف</option>
                    <option value="abha">أبها</option>
                    <option value="tabuk">تبوك</option>
                </select> --}}
                <x-form.city-select name="city_id" class="form-select" :selected="old('phone_number', $user->city->id ?? '')" />

                @error('city_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password">{{ __('dashboard.password') }}</label>
                <input type="password" name="password" id="password" class="form-control" {{ $isEdit ? '' : 'required' }}>
                @if($isEdit)
                    <small class="form-text text-muted">{{ __('dashboard.leave_blank_keep_password') }}</small>
                @endif
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group mb-3">
                <label for="password_confirmation">{{ __('dashboard.confirm_password') }}</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" {{ $isEdit ? '' : 'required' }}>
                @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="tab-pane {{ $activeTab === 'roles' ? 'active show' : '' }}" id="roles">
            {{-- Roles selection --}}
            <div class="form-group mb-3">
                <label for="roles">{{ __('dashboard.roles') }}</label>
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
        {{ $isEdit ? __('dashboard.update_user') : __('dashboard.create_user') }}
    </button>
</form>
