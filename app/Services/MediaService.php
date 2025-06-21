<?php

namespace App\Services;

use App\Contracts\FileStorage;
use App\Factories\StorageStrategyFactory;
use Illuminate\Http\UploadedFile;

class MediaService
{
    protected StorageStrategyFactory $factory;

    public function __construct(StorageStrategyFactory $factory)
    {
        $this->factory = $factory;
    }


    /**
     * the strategies is {{dedicated_table , single_column or morph}}
     * the default srtategy is morph
     * for use single_column we need to model opject in $model param and column_name in config['column']
     * for use dedicated_table we need to model opject in $model and $config['table'] ,$config['column'] ,$config['foreign_key']
     * for use morph we need to only model that we relation the photo with it
     */

    /**
     * Store a single file using the specified storage strategy.
     *
     * @param UploadedFile $file
     * @param mixed $model
     * @param string $type
     * @param string $path
     * @param string $strategy
     * @param array $config
     * @return void
     */
    public function storeSingle(UploadedFile $file, $model, string $type, string $path = 'media', string $strategy = 'morph', array $config = []): void
    {
        $storage = $this->factory->make($strategy, $config);
        $storage->store($file, $model, $type, $path);
    }

    /**
     * Store multiple files using the specified storage strategy.
     *
     * @param array<UploadedFile> $files
     * @param mixed $model
     * @param string $type
     * @param string $path
     * @param string $strategy
     * @param array $config
     * @return void
     */
    public function storeMultiple(array $files, $model, string $type, string $path = 'media', string $strategy = 'morph', array $config = []): void
    {
        $storage = $this->factory->make($strategy, $config);
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $storage->store($file, $model, $type, $path);
            }
        }
    }

    /**
     * Update a single file using the specified storage strategy.
     *
     * @param UploadedFile $file
     * @param mixed $model
     * @param string $type
     * @param string $path
     * @param string $strategy
     * @param array $config
     * @return void
     */
    public function updateSingle(UploadedFile $file, $model, string $type, string $path = 'media', string $strategy = 'morph', array $config = []): void
    {
        $storage = $this->factory->make($strategy, $config);
        $storage->update($file, $model, $type, $path);
    }

    /**
     * Delete files by type using the specified storage strategy.
     *
     * @param mixed $model
     * @param string $type
     * @param string $strategy
     * @param array $config
     * @return void
     */
    public function delete($model, string $type, string $strategy = 'morph', array $config = []): void
    {
        $storage = $this->factory->make($strategy, $config);
        $storage->delete($model, $type);
    }

    /**
     * Delete a specific media file by ID using the specified storage strategy.
     *
     * @param int $mediaId
     * @param string $strategy
     * @param array $config
     * @return void
     */
    public function deleteSingle(int $mediaId, string $strategy = 'morph', array $config = []): void
    {
        $storage = $this->factory->make($strategy, $config);
        $storage->deleteSingle($mediaId);
    }

    /**
     * Update a specific media file by ID using the specified storage strategy.
     *
     * @param UploadedFile $file
     * @param int $mediaId
     * @param string $path
     * @param string $strategy
     * @param array $config
     * @return void
     */
    public function updateMedia(UploadedFile $file, int $mediaId, string $path = 'media', string $strategy = 'morph', array $config = []): void
    {
        $storage = $this->factory->make($strategy, $config);
        $storage->updateMedia($file, $mediaId, $path);
    }
}