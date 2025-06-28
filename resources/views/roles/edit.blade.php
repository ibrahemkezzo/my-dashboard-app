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
        <h1>تعديل الدور: {{ $role->name }}</h1>
        <form action="{{ route('dashboard.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="name">اسم الدور</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="description">الوصف</label>
                <textarea name="description" id="description" class="form-control">{{ $role->description }}</textarea>
            </div>
            <div class="form-group mb-3">
                <label>الصلاحيات</label>
                @foreach ($permissions as $permission)
                    <div class="form-check">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission-{{ $permission->id }}"
                            {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                        <label for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">تحديث الدور</button>
        </form>
    </div>
</body>
</html>