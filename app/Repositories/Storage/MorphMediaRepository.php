<?php

namespace App\Repositories\Storage;

use App\Contracts\FileStorage;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MorphMediaRepository implements FileStorage
{
    public function store(UploadedFile $file, $model, string $type, string $path): void
    {
        $filePath = $file->store($path, 'public');
        Media::create([
            'mediable_id' => $model->id,
            'mediable_type' => get_class($model),
            'path' => $filePath,
            'type' => $type,
            'disk' => 'public',
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    public function update(UploadedFile $file, $model, string $type, string $path): void
    {
        $this->delete($model, $type);
        $this->store($file, $model, $type, $path);
    }

    public function delete($model, string $type): void
    {
        $media = Media::where([
            'mediable_id' => $model->id,
            'mediable_type' => get_class($model),
            'type' => $type,
        ])->get();

        foreach ($media as $item) {
            Storage::disk($item->disk)->delete($item->path);
            $item->delete();
        }
    }

    public function deleteSingle(int $mediaId): void
    {
        $media = Media::findOrFail($mediaId);
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();
    }

    public function updateMedia(UploadedFile $file, int $mediaId, string $path): void
    {
        $media = Media::findOrFail($mediaId);
        Storage::disk($media->disk)->delete($media->path);
        $filePath = $file->store($path, 'public');
        $media->update([
            'path' => $filePath,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);
    }
}