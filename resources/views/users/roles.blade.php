<html>
    <header>

    </header>
    <body>


    <div class="container">
        <h1>إدارة الأدوار للمستخدم: {{ $user->name }}</h1>
        <form action="{{ route('users.assign-roles', $user) }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label>الأدوار</label>
                @foreach ($roles as $id => $name)
                    <div class="form-check">
                        <input type="checkbox" name="roles[]" value="{{ $name }}" id="role-{{ $id }}" {{ in_array($name, $userRoles) ? 'checked' : '' }}>
                        <label for="role-{{ $id }}">{{ $name }}</label>
                    </div>
                @endforeach
                @error('roles')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">تعيين الأدوار</button>
            <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">رجوع</a>
        </form>
    </div>

    </body>
</html>