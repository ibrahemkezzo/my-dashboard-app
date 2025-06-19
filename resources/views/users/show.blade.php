<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container">
        <h1>المستخدم: {{ $user->name }}</h1>
        <p><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
        <p><strong>الأدوار:</strong> {{ $user->roles->pluck('name')->implode(', ') ?: 'لا توجد أدوار' }}</p>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning mt-3">تعديل</a>
        <a href="{{ route('users.editRoles', $user) }}" class="btn btn-primary mt-3">إدارة الأدوار</a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">رجوع</a>
    </div>
</x-app-layout>