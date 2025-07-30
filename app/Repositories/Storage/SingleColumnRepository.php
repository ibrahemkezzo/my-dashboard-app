<?php

namespace App\Repositories\Storage;

use App\Contracts\FileStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SingleColumnRepository implements FileStorage
{
    protected string $column;

    public function __construct(string $column = 'image')
    {
        $this->column = $column;
    }

    public function store(UploadedFile $file, Model $model, string $type, string $path): void
    {
        $filePath = $file->store($path, 'public');

        if ($model instanceof Model) {
            $model->update([$this->column => $filePath]);
        } else {
            $model->{$this->column} = $filePath;
        }

    }

    public function update(UploadedFile $file,Model $model, string $type, string $path): void
    {
        if ($model->{$this->column}) {
            Storage::disk('public')->delete($model->{$this->column});
        }
        $this->store($file, $model, $type, $path);
    }

    public function delete($model, string $type): void
    {
        if ($model->{$this->column}) {
            Storage::disk('public')->delete($model->{$this->column});
            $model->update([$this->column => null]);
        }
    }

    public function deleteSingle(int $mediaId): void
    {
        throw new \Exception('Single media deletion is not supported for SingleColumnStorage.');
    }

    public function updateMedia(UploadedFile $file, int $mediaId, string $path): void
    {
        throw new \Exception('Single media update is not supported for SingleColumnStorage.');
    }
}