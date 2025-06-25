<?php

namespace App\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for MediaService to handle file storage operations using different strategies.
 *
 * Available storage strategies:
 * - 'morph': Stores files in a polymorphic media table (e.g., 'media') linked to a model.
 * - 'single_column': Stores a single file path in a specified column of the model's table.
 * - 'dedicated_table': Stores files in a dedicated table with a foreign key to the model.
 *
 * @method static void storeSingle(UploadedFile $file, mixed $model, string $type, string $path = 'media', string $strategy = 'morph', array $config = [])
 * @method static void storeMultiple(array $files, mixed $model, string $type, string $path = 'media', string $strategy = 'morph', array $config = [])
 * @method static void updateSingle(UploadedFile $file, mixed $model, string $type, string $path = 'media', string $strategy = 'morph', array $config = [])
 * @method static void delete(mixed $model, string $type, string $strategy = 'morph', array $config = [])
 * @method static void deleteSingle(int $mediaId, string $strategy = 'morph', array $config = [])
 * @method static void updateMedia(UploadedFile $file, int $mediaId, string $path = 'media', string $strategy = 'morph', array $config = [])
 */
class Media extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\MediaService::class;
    }

    /**
     * Store a single file using the specified storage strategy.
     *
     * @param UploadedFile $file The file to store.
     * @param mixed $model The model instance or object to associate the file with.
     * @param string $type The type of media (e.g., 'site_logo', 'service_image', 'about_us_image').
     * @param string $path The storage path (default: 'media').
     * @param string $strategy The storage strategy ('morph', 'single_column', 'dedicated_table'). Default: 'morph'.
     * @param array $config Configuration for the strategy:
     *                      - For 'single_column': ['column' => 'image'] (column name to store the file path).
     *                      - For 'dedicated_table': ['table' => 'media_files', 'column' => 'path', 'foreign_key' => 'model_id'].
     *                      - For 'morph': No config required.
     * @return void
     */


    /**
     * Store multiple files using the specified storage strategy.
     *
     * @param array<UploadedFile> $files Array of files to store.
     * @param mixed $model The model instance or object to associate the files with.
     * @param string $type The type of media (e.g., 'gallery_images', 'service_image').
     * @param string $path The storage path (default: 'media').
     * @param string $strategy The storage strategy ('morph', 'single_column', 'dedicated_table'). Default: 'morph'.
     * @param array $config Configuration for the strategy:
     *                      - For 'single_column': ['column' => 'image'] (column name to store the file path).
     *                      - For 'dedicated_table': ['table' => 'media_files', 'column' => 'path', 'foreign_key' => 'model_id'].
     *                      - For 'morph': No config required.
     * @return void
     */


    /**
     * Update a single file using the specified storage strategy, deleting the old file if exists.
     *
     * @param UploadedFile $file The new file to store.
     * @param mixed $model The model instance or object associated with the file.
     * @param string $type The type of media (e.g., 'site_logo', 'service_image').
     * @param string $path The storage path (default: 'media').
     * @param string $strategy The storage strategy ('morph', 'single_column', 'dedicated_table'). Default: 'morph'.
     * @param array $config Configuration for the strategy:
     *                      - For 'single_column': ['column' => 'image'] (column name to store the file path).
     *                      - For 'dedicated_table': ['table' => 'media_files', 'column' => 'path', 'foreign_key' => 'model_id'].
     *                      - For 'morph': No config required.
     * @return void
     */


    /**
     * Delete files associated with a model by type using the specified storage strategy.
     *
     * @param mixed $model The model instance or object associated with the files.
     * @param string $type The type of media to delete (e.g., 'service_image', 'site_logo').
     * @param string $strategy The storage strategy ('morph', 'single_column', 'dedicated_table'). Default: 'morph'.
     * @param array $config Configuration for the strategy:
     *                      - For 'single_column': ['column' => 'image'] (column name to clear).
     *                      - For 'dedicated_table': ['table' => 'media_files', 'column' => 'path', 'foreign_key' => 'model_id'].
     *                      - For 'morph': No config required.
     * @return void
     */

    /**
     * Delete a specific media file by its ID using the specified storage strategy.
     *
     * @param int $mediaId The ID of the media record to delete.
     * @param string $strategy The storage strategy ('morph', 'dedicated_table'). Default: 'morph'.
     *                         Note: 'single_column' does not support this operation.
     * @param array $config Configuration for the strategy:
     *                      - For 'dedicated_table': ['table' => 'media_files', 'column' => 'path', 'foreign_key' => 'model_id'].
     *                      - For 'morph': No config required.
     * @return void
     * @throws \Exception If the strategy is 'single_column'.
     */


    /**
     * Update a specific media file by its ID using the specified storage strategy.
     *
     * @param UploadedFile $file The new file to store.
     * @param int $mediaId The ID of the media record to update.
     * @param string $path The storage path (default: 'media').
     * @param string $strategy The storage strategy ('morph', 'dedicated_table'). Default: 'morph'.
     *                         Note: 'single_column' does not support this operation.
     * @param array $config Configuration for the strategy:
     *                      - For 'dedicated_table': ['table' => 'media_files', 'column' => 'path', 'foreign_key' => 'model_id'].
     *                      - For 'morph': No config required.
     * @return void
     * @throws \Exception If the strategy is 'single_column'.
     */
 
}