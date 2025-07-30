<?php

namespace App\Repositories;

use App\Contracts\SettingsInterface;
use App\Models\Setting;

class DatabaseSettingsRepository implements SettingsInterface
{
    /**
     * Retrieve a setting by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : null;
    }

    public function getModel(string $key)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting : null;
    }

    /**
     * Retrieve all settings by type.
     *
     * @param string $type
     * @return array
     */
    public function all(string $type = 'general'): array
    {
        return Setting::where('type', $type)
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Store or update a setting.
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return array
     */
    public function set(string $key, $value, string $type = 'general'): array
    {
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );

        return [
            'key' => $setting->key,
            'value' => $setting->value,
            'type' => $setting->type,
        ];
    }

    /**
     * Delete a setting by key.
     *
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        return Setting::where('key', $key)->delete() > 0;
    }
}