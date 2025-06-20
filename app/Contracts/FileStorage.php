<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface FileStorage
{
    public function store(UploadedFile $file, $model, string $type, string $path): void;
    public function update(UploadedFile $file, $model, string $type, string $path): void;
    public function delete($model, string $type): void;
    public function deleteSingle(int $mediaId): void;
    public function updateMedia(UploadedFile $file, int $mediaId, string $path): void;
}