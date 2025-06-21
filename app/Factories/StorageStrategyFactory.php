<?php

namespace App\Factories;

use App\Contracts\FileStorage;
use App\Repositories\Storage\DedicatedTableRepository;
use App\Repositories\Storage\MorphMediaRepository;
use App\Repositories\Storage\SingleColumnRepository;
use InvalidArgumentException;

class StorageStrategyFactory
{
    /**
     * Create a storage strategy instance based on the given type.
     *
     * @param string $strategy
     * @param array $config
     * @return FileStorage
     * @throws InvalidArgumentException
     */
    public function make(string $strategy, array $config = []): FileStorage
    {
        switch ($strategy) {
            case 'single_column':
                return new SingleColumnRepository($config['column'] ?? 'image');
            case 'morph':
                return new MorphMediaRepository();
            case 'dedicated_table':
                return new DedicatedTableRepository(
                    $config['table'] ?? 'media_files',
                    $config['column'] ?? 'path',
                    $config['foreign_key'] ?? 'model_id'
                );
            default:
                throw new InvalidArgumentException("Unsupported storage strategy: {$strategy}");
        }
    }
}