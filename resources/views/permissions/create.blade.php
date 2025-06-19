<html>
    <header>

    </header>
    <body>
        <div class="container">
            <h1>إنشاء صلاحية جديدة</h1>
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">اسم الصلاحية</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">إنشاء الصلاحية</button>
            </form>
        </div>
    </body>
</html>