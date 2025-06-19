<html>
    <header>

    </header>
    <body>
        <div class="container">
            <h1>تعديل الصلاحية: {{ $permission->name }}</h1>
            <form action="{{ route('permissions.update', $permission) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="name">اسم الصلاحية</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $permission->name }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">تحديث الصلاحية</button>
            </form>
        </div>
    </body>
</html>