
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
        <h1>إدارة الأدوار</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('dashboard.roles.create') }}" class="btn btn-primary mb-3">إنشاء دور جديد</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المعرف</th>
                    <th>الاسم</th>
                    <th>الوصف</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description ?? 'لا يوجد' }}</td>
                        <td>
                            <a href="{{ route('dashboard.roles.show', $role) }}" class="btn btn-info btn-sm">عرض</a>
                            <a href="{{ route('dashboard.roles.edit', $role) }}" class="btn btn-warning btn-sm">تعديل</a>
                            <form action="{{ route('dashboard.roles.destroy', $role) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>