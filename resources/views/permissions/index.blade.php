<html>
    <header>

    </header>
    <body>
        <div class="container">
            <h1>إدارة الصلاحيات</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">إنشاء صلاحية جديدة</a>
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
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->description ?? 'لا يوجد' }}</td>
                            <td>
                                <a href="{{ route('permissions.show', $permission) }}" class="btn btn-info btn-sm">عرض</a>
                                <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-warning btn-sm">تعديل</a>
                                <form action="{{ route('permissions.destroy', $permission) }}" method="POST" style="display:inline;">
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