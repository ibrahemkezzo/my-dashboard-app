<?php

namespace App\Services\Storage;

use App\Contracts\FileStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DedicatedTableStorage implements FileStorage
{
    protected string $table;
    protected string $column;
    protected string $foreignKey;

    public function __construct(string $table, string $column = 'path', string $foreignKey = 'model_id')
    {
        $this->table = $table;
        $this->column = $column;
        $this->foreignKey = $foreignKey;
    }

    public function store(UploadedFile $file, $model, string $type, string $path): void
    {
        $filePath = $file->store($path, 'public');
        \Illuminate\Support\Facades\DB::table($this->table)->insert([
            $this->foreignKey => $model->id,
            $this->column => $filePath,
            'type' => $type,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function update(UploadedFile $file, $model, string $type, string $path): void
    {
        $this->delete($model, $type);
        $this->store($file, $model, $type, $path);
    }

    public function delete($model, string $type): void
    {
        $records = \Illuminate\Support\Facades\DB::table($this->table)
            ->where($this->foreignKey, $model->id)
            ->where('type', $type)
            ->get();

        foreach ($records as $record) {
            Storage::disk('public')->delete($record->{$this->column});
        }

        \Illuminate\Support\Facades\DB::table($this->table)
            ->where($this->foreignKey, $model->id)
            ->where('type', $type)
            ->delete();
    }

    public function deleteSingle(int $mediaId): void
    {
        $record = \Illuminate\Support\Facades\DB::table($this->table)
            ->where('id', $mediaId)
            ->first();

        if ($record) {
            Storage::disk('public')->delete($record->{$this->column});
            \Illuminate\Support\Facades\DB::table($this->table)
                ->where('id', $mediaId)
                ->delete();
        }
    }

    public function updateMedia(UploadedFile $file, int $mediaId, string $path): void
    {
        $record = \Illuminate\Support\Facades\DB::table($this->table)
            ->where('id', $mediaId)
            ->first();

        if ($record) {
            Storage::disk('public')->delete($record->{$this->column});
            $filePath = $file->store($path, 'public');
            \Illuminate\Support\Facades\DB::table($this->table)
                ->where('id', $mediaId)
                ->update([
                    $this->column => $filePath,
                    'updated_at' => now(),
                ]);
        }
    }
}