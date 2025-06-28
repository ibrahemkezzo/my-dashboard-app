<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


    <div class="container">
        <h1>الدور: {{ $role->name }}</h1>
        <p><strong>الوصف:</strong> {{ $role->description ?? 'لا يوجد' }}</p>
        <h3>الصلاحيات المعينة</h3>
        <ul>
            @foreach ($role->permissions as $permission)
                <li>{{ $permission->name }}</li>
            @endforeach
        </ul>
        <a href="{{ route('dashboard.roles.edit', $role) }}" class="btn btn-warning">تعديل</a>
        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-secondary">رجوع</a>
    </div>

</body>
</html>