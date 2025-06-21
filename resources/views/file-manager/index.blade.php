<html>
    <header>

    </header>
    <body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('الملفات والمجلدات') }}</h3>

                    @if (session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Directories -->
                    <h4 class="mb-3">{{ __('المجلدات') }}</h4>
                    <div class="row">
                        @foreach ($directories as $dir)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $dir['path'] }}</h5>
                                        <p class="card-text">{{ count($dir['files']) }} {{ __('ملفات') }}</p>
                                        <a href="#" class="btn btn-primary">{{ __('عرض') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Media Files -->
                    <h4 class="mb-3">{{ __('الملفات المرتبطة') }}</h4>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('الصورة') }}</th>
                                <th>{{ __('النوع') }}</th>
                                <th>{{ __('المالك') }}</th>
                                <th>{{ __('الإجراءات') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($media as $item)
                            {{-- @dd($item->url) --}}
                                <tr>
                                    <td>
                                        <img src="{{$item->url }}" alt="{{ $item->type }}" style="max-width: 100px;">
                                    </td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->mediable ? class_basename($item->mediable) . ' #' . $item->mediable->id : 'غير مرتبط' }}</td>
                                    <td>
                                        <!-- Update Form -->
                                        <form action="{{ route('media.update', $item->id) }}" method="POST" enctype="multipart/form-data" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="file" name="file" accept="image/*" onchange="this.form.submit()">
                                        </form>
                                        <!-- Delete Form -->
                                        <form action="{{ route('file-manager.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('هل أنت متأكد من حذف الملف؟') }}')">
                                                {{ __('حذف') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $media->links() }}
                </div>
            </div>
        </div>
    </body>
</html>