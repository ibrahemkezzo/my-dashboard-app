<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasDynamicMediaUrl
{
    /**
     * Get the URL of the model's associated media.
     *
     * @return string|null
     */
    public function getUrlAttribute(): ?string
    {
        // Get the media path or data from the model's custom logic
        $mediaData = $this->getMediaData();

        if (!$mediaData) {
            return $this->getDefaultImageUrl(); // Return default image if no media
        }

        // Handle different types of media data
        if (is_string($mediaData)) {
            // Case 1: Media data is a direct path (e.g., stored in `image_path` column)
            return $this->generateUrlFromPath($mediaData);
        } elseif ($mediaData instanceof \App\Models\Media) {
            // Case 2: Media data is a Media model instance
            return $this->generateUrlFromMedia($mediaData);
        } elseif (is_array($mediaData) && isset($mediaData['path']) && isset($mediaData['disk'])) {
            // Case 3: Media data is an array with path and disk
            return $this->generateUrlFromArray($mediaData);
        }

        // Fallback to default image if no valid media data
        return $this->getDefaultImageUrl();
    }

    /**
     * Define how to retrieve media data for the model.
     * Override this method in the model to provide custom logic.
     *
     * @return mixed|null (string, Media model, or array with path and disk)
     */
    protected function getMediaData()
    {
        // Default implementation: Check for a `media` relationship or `image_path` column
        if ($this->relationLoaded('media') && $this->media) {
            return $this->media()->first();
        } elseif ($this->image_path) {
            return $this->image_path;
        }

        return null; // No media data by default
    }

    /**
     * Generate URL from a direct path.
     *
     * @param string $path
     * @return string
     */
    protected function generateUrlFromPath(string $path): string
    {
        return asset('/storage/' . ltrim($path, '/'));
    }

    /**
     * Generate URL from a Media model instance.
     *
     * @param \App\Models\Media $media
     * @return string
     */
    protected function generateUrlFromMedia(\App\Models\Media $media): string
    {
        if ($media->disk === 'public') {
            return asset('/storage/' . ltrim($media->path, '/'));
        }

        return asset(Storage::disk($media->disk)->url($media->path));
    }

    /**
     * Generate URL from an array containing path and disk.
     *
     * @param array $data
     * @return string
     */
    protected function generateUrlFromArray(array $data): string
    {
        if ($data['disk'] === 'public') {
            return asset('/storage/' . ltrim($data['path'], '/'));
        }

        return asset(Storage::disk($data['disk'])->url($data['path']));
    }

    /**
     * Get the default image URL if no media is available.
     *
     * @return string
     */
    protected function getDefaultImageUrl(): string
    {
        return asset('default-image.jpg');
    }
}