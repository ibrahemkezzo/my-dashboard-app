<html>
    <header>

    </header>
    <body>
        <div class="container">
            <h1>الصلاحية: {{ $permission->name }}</h1>
            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-warning">تعديل</a>
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">رجوع</a>
        </div>
    </body>
</html>