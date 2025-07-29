<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>معرض الصور</h5>
        <form action="{{ route('front.profile.salon.manager.gallery.add') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
            @csrf
            <input type="file" name="gallery_images[]" multiple accept="image/*" class="form-control d-inline-block" style="width:200px;display:inline-block;">
            <button type="submit" class="btn btn-primary btn-sm">إضافة صور</button>
        </form>
    </div>
    <div class="card-body">
        @if($salon->media && $salon->media->count() > 0)
            <div class="row mt-2">
                @foreach($salon->media as $media)
                    <div class="col-md-2 text-center mb-2">
                        <img src="{{ asset('storage/'.$media->path) }}" alt="gallery" style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                        <form action="{{ route('front.profile.salon.manager.gallery.delete', $media->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف الصورة؟')">حذف</button>
                        </form>
                        <form action="{{ route('front.profile.salon.manager.gallery.update', $media->id) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                            @csrf
                            <input type="file" name="image" accept="image/*" class="form-control form-control-sm mb-1" required>
                            <button type="submit" class="btn btn-info btn-sm">تحديث</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">لا توجد صور في المعرض.</p>
        @endif
    </div>
</div> 