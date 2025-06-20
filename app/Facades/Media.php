<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void storeSingle(\Illuminate\Http\UploadedFile $file, mixed $model, string $type, string $path = 'media')
 * @method static void storeMultiple(array $files, mixed $model, string $type, string $path = 'media')
 * @method static void updateSingle(\Illuminate\Http\UploadedFile $file, mixed $model, string $type, string $path = 'media')
 * @method static void delete(mixed $model, string $type)
 * @method static void deleteSingle(int $mediaId)
 * @method static void updateMedia(\Illuminate\Http\UploadedFile $file, int $mediaId, string $path = 'media')
 */
class Media extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\MediaService::class;
    }
}