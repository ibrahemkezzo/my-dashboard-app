<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container">
        <h1>الدور: {{ $role->name }}</h1>
        <p><strong>الوصف:</strong> {{ $role->description ?? 'لا يوجد' }}</p>
        <h3>الصلاحيات المعينة</h3>
        <ul>
            @foreach ($role->permissions as $permission)
                <li>{{ $permission->name }}</li>
            @endforeach
        </ul>
        <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning">تعديل</a>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">رجوع</a>
    </div>

</x-app-layout>