<?php

namespace App\Contracts;

interface SettingsInterface
{
    /**
     * Retrieve a setting by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key);
    public function getModel(string $key);

    /**
     * Retrieve all settings by type.
     *
     * @param string $type
     * @return array
     */
    public function all(string $type = 'general'): array;

    /**
     * Store or update a setting.
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return array
     */
    public function set(string $key, $value, string $type = 'general'): array;

    /**
     * Delete a setting by key.
     *
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool;
}