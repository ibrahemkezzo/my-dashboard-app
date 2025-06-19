<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container">
        <h1>إنشاء مستخدم جديد</h1>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name">الاسم</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="password">كلمة المرور</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="password_confirmation">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>الأدوار</label>
                @foreach ($roles as $id => $name)
                    <div class="form-check">
                        <input type="checkbox" name="roles[]" value="{{ $name }}" id="role-{{ $id }}">
                        <label for="role-{{ $id }}">{{ $name }}</label>
                    </div>
                @endforeach
                @error('roles')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">إنشاء</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">رجوع</a>
        </form>
    </div>

</x-app-layout>