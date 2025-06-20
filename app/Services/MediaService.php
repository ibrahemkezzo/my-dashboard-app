<?php

namespace App\Services;

use App\Contracts\FileStorage;
use Illuminate\Http\UploadedFile;

class MediaService
{
    protected FileStorage $storage;

    public function __construct(FileStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Store a single file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param mixed $model
     * @param string $type
     * @param string $path
     * @return void
     */
    public function storeSingle(UploadedFile $file, $model, string $type, string $path = 'media'): void
    {
        $this->storage->store($file, $model, $type, $path);
    }

    /**
     * Store multiple files.
     *
     * @param array<\Illuminate\Http\UploadedFile> $files
     * @param mixed $model
     * @param string $type
     * @param string $path
     * @return void
     */
    public function storeMultiple(array $files, $model, string $type, string $path = 'media'): void
    {
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $this->storage->store($file, $model, $type, $path);
            }
        }
    }

    /**
     * Update a single file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param mixed $model
     * @param string $type
     * @param string $path
     * @return void
     */
    public function updateSingle(UploadedFile $file, $model, string $type, string $path = 'media'): void
    {
        $this->storage->update($file, $model, $type, $path);
    }

    /**
     * Delete files by type.
     *
     * @param mixed $model
     * @param string $type
     * @return void
     */
    public function delete($model, string $type): void
    {
        $this->storage->delete($model, $type);
    }

    /**
     * Delete a specific media file by ID.
     *
     * @param int $mediaId
     * @return void
     */
    public function deleteSingle(int $mediaId): void
    {
        $this->storage->deleteSingle($mediaId);
    }

    /**
     * Update a specific media file by ID.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param int $mediaId
     * @param string $path
     * @return void
     */
    public function updateMedia(UploadedFile $file, int $mediaId, string $path = 'media'): void
    {
        $this->storage->updateMedia($file, $mediaId, $path);
    }
}