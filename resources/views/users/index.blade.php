<html>
    <header>

    </header>
    <body>




    <div class="container">
        <h1>إدارة المستخدمين</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">إنشاء مستخدم جديد</a>

        <form method="GET" action="{{ route('users.index') }}" class="mb-3">
            <div class="form-group mb-3">
                <label for="search">البحث</label>
                <input type="text" name="search" id="search" class="form-control" value="{{ $search ?? '' }}" placeholder="ابحث بالاسم أو البريد الإلكتروني">
            </div>
            <div class="form-group">
                <label for="roles">تصفية حسب الأدوار</label>
                <select name="roles[]" id="roles" class="form-control" multiple>
                    @foreach ($roles as $id => $name)
                        <option value="{{ $name }}" {{ in_array($name, $selectedRoles) ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-secondary mt-2">تصفية</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الأدوار</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->pluck('name')->implode(', ') ?: 'لا توجد أدوار' }}</td>
                        <td>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">عرض</a>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">تعديل</a>
                            <a href="{{ route('users.editRoles', $user) }}" class="btn btn-primary btn-sm">إدارة الأدوار</a>
                            <form action="{{ route('users.toggleStatus', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }} btn-sm" onclick="return confirm('هل أنت متأكد من {{ $user->is_active ? 'تعطيل' : 'تفعيل' }} المستخدم؟')">
                                    {{ $user->is_active ? 'تعطيل' : 'تفعيل' }}
                                </button>
                            </form>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف المستخدم؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">لا توجد مستخدمين.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('users.export') }}" class="btn btn-success mb-3">تصدير إلى Excel</a>
    </div>

    </body>
</html>