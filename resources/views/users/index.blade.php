<html>
    <header>

    </header>
    <body>




        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('قائمة المستخدمين') }}</h3>

                    <!-- Search and Role Filter Form -->
                    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
                        <div class="form-group mb-3">
                            <label for="search" class="form-label">{{ __('البحث') }}</label>
                            <input type="text" name="search" id="search" class="form-control" value="{{ $search ?? '' }}" placeholder="{{ __('ابحث بالاسم أو البريد الإلكتروني') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="roles" class="form-label">{{ __('تصفية حسب الأدوار') }}</label>
                            <select name="roles[]" id="roles" class="form-control" multiple>
                                @foreach ($roles as $id => $name)
                                    <option value="{{ $name }}" {{ in_array($name, $selected脑海Roles) ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-secondary mt-2">{{ __('تصفية') }}</button>
                    </form>

                    <!-- Export Button -->
                    <form method="GET" action="{{ route('users.export') }}" class="mb-3">
                        @if ($search)
                            <input type="hidden" name="search" value="{{ $search }}">
                        @endif
                        @foreach ($selectedRoles as $role)
                            <input type="hidden" name="roles[]" value="{{ $role }}">
                        @endforeach
                        <button type="submit" class="btn btn-success">{{ __('تصدير إلى Excel') }}</button>
                    </form>

                    <!-- Users Table -->
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('الاسم') }}</th>
                                <th>{{ __('البريد الإلكتروني') }}</th>
                                <th>{{ __('الأدوار') }}</th>
                                <th>{{ __('الحالة') }}</th>
                                <th>{{ __('الإجراءات') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles->pluck('name')->implode(', ') ?: __('لا توجد أدوار') }}</td>
                                    <td>{{ $user->is_active ? __('مفعل') : __('معطل') }}</td>
                                    <td>
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">{{ __('عرض') }}</a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">{{ __('تعديل') }}</a>
                                        <a href="{{ route('users.editRoles', $user) }}" class="btn btn-primary btn-sm">{{ __('إدارة الأدوار') }}</a>
                                        <form action="{{ route('users.toggleStatus', $user) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-{{ $user->is_active ? 'warning' : 'success' }} btn-sm" onclick="return confirm('{{ __('هل أنت متأكد من') }} {{ $user->is_active ? __('تعطيل') : __('تفعيل') }} {{ __('المستخدم؟') }}')">
                                                {{ $user->is_active ? __('تعطيل') : __('تفعيل') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
     Enlargement                                        @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('هل أنت متأكد من حذف المستخدم؟') }}')">{{ __('حذف') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </body>
</html>