<?php

namespace App\Services;

use App\Contracts\SettingsInterface;
use App\Facades\Media;
use App\Models\Service;
use Illuminate\Http\UploadedFile;

class SettingsService
{
    protected SettingsInterface $repository;

    /**
     * SettingsService constructor.
     *
     * @param SettingsInterface $repository
     */
    public function __construct(SettingsInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve a setting by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->repository->get($key, $default);
    }

    /**
     * Retrieve all general settings with default values.
     *
     * @return array
     */
    public function getGeneralSettings(): array
    {
        $defaults = [
            'site_name' => '',
            'site_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'default_language' => 'ar',
            'site_status' => 'active',
            'maintenance_message' => '',
            'email_settings' => '',
            'analytics_code' => '',
            'social_links' => [],
            'notification_settings' => [],
            'footer_text' => '',
        ];

        return array_merge($defaults, $this->repository->all('general'));
    }

    /**
     * Retrieve all About Us settings with default values.
     *
     * @return array
     */
    public function getAboutUsSettings(): array
    {
        $defaults = [
            'about_us_title' => '',
            'about_us_description' => '',
            'about_us_vision' => '',
            'about_us_mission' => '',
            'about_us_values' => [],
            'about_us_video_url' => '',
            'about_us_founded_at' => '',
            'about_us_employees_count' => 0,
            'about_us_statistics' => [],
        ];

        return array_merge($defaults, $this->repository->all('about_us'));
    }

    /**
     * Retrieve all Contact Us settings with default values.
     *
     * @return array
     */
    public function getContactUsSettings(): array
    {
        $defaults = [
            'contact_us_title' => '',
            'contact_us_description' => '',
            'contact_us_email' => '',
            'contact_us_phone_numbers' => [],
            'contact_us_address' => '',
            'contact_us_map_url' => '',
            'contact_us_social_links' => [],
            'contact_us_form_settings' => [],
            'contact_us_working_hours' => '',
            'contact_us_success_message' => '',
        ];

        return array_merge($defaults, $this->repository->all('contact_us'));
    }

    /**
     * Update general settings with default values.
     *
     * @param array $data
     * @param array $files
     * @return array
     */
    public function updateGeneralSettings(array $data, array $files = []): array
    {
        $defaults = [
            'site_name' => '',
            'site_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'default_language' => 'ar',
            'site_status' => 'active',
            'maintenance_message' => '',
            'email_settings' => '',
            'analytics_code' => '',
            'social_links' => [],
            'notification_settings' => [],
            'footer_text' => '',
        ];

        $data = array_merge($defaults, $data);
        $updatedSettings = [];

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $defaults)) {
                $updatedSettings[$key] = $this->repository->set($key, $value, 'general');
            }
        }

        if (isset($files['site_logo'])) {
            Media::storeSingle($files['site_logo'], new \stdClass(), 'site_logo', 'settings');
        }
        if (isset($files['cover_image'])) {
            Media::storeSingle($files['cover_image'], new \stdClass(), 'cover_image', 'settings');
        }
        if (isset($files['favicon'])) {
            Media::storeSingle($files['favicon'], new \stdClass(), 'favicon_icon', 'settings');
        }

        return [
            'data' => $updatedSettings,
            'message' => __('General settings updated successfully.'),
        ];
    }

    /**
     * Update About Us settings with default values.
     *
     * @param array $data
     * @param UploadedFile|null $image
     * @return array
     */
    public function updateAboutUsSettings(array $data, ?UploadedFile $image = null): array
    {
        $defaults = [
            'title' => '',
            'description' => '',
            'vision' => '',
            'mission' => '',
            'values' => [],
            'video_url' => '',
            'founded_at' => '',
            'employees_count' => 0,
            'statistics' => [],
        ];

        $data = array_merge($defaults, $data);
        $updatedSettings = [];

        foreach ($data as $key => $value) {
            $mappedKey = 'about_us_' . $key;
            if (array_key_exists($key, $defaults)) {
                $updatedSettings[$mappedKey] = $this->repository->set($mappedKey, $value, 'about_us');
            }
        }

        if ($image) {
            Media::storeSingle($image, new \stdClass(), 'about_us_image', 'settings');
        }

        return [
            'data' => $updatedSettings,
            'message' => __('About Us settings updated successfully.'),
        ];
    }

    /**
     * Update Contact Us settings with default values.
     *
     * @param array $data
     * @return array
     */
    public function updateContactUsSettings(array $data): array
    {
        $defaults = [
            'title' => '',
            'description' => '',
            'email' => '',
            'phone_numbers' => [],
            'address' => '',
            'map_url' => '',
            'social_links' => [],
            'form_settings' => [],
            'working_hours' => '',
            'success_message' => '',
        ];

        $data = array_merge($defaults, $data);
        $updatedSettings = [];

        foreach ($data as $key => $value) {
            $mappedKey = 'contact_us_' . $key;
            if (array_key_exists($key, $defaults)) {
                $updatedSettings[$mappedKey] = $this->repository->set($mappedKey, $value, 'contact_us');
            }
        }

        return [
            'data' => $updatedSettings,
            'message' => __('Contact Us settings updated successfully.'),
        ];
    }

    /**
     * Create or update a service.
     *
     * @param array $data
     * @param UploadedFile|null $image
     * @param Service|null $service
     * @return array
     */
    public function updateService(array $data, ?UploadedFile $image = null, ?Service $service = null): array
    {
        $defaults = [
            'name' => '',
            'short_description' => '',
            'long_description' => '',
            'custom_url' => '',
            'order' => 0,
            'status' => true,
            'seo_meta' => [],
        ];

        $data = array_merge($defaults, $data);
        $serviceData = array_intersect_key($data, $defaults);

        if ($service) {
            $service->update($serviceData);
        } else {
            $service = Service::create($serviceData);
        }

        if ($image) {
            Media::storeSingle($image, $service, 'service_image', 'services');
        }

        return [
            'data' => $service,
            'message' => $service->wasRecentlyCreated
                ? __('Service added successfully.')
                : __('Service updated successfully.'),
        ];
    }

    /**
     * Delete a service and its associated media.
     *
     * @param Service $service
     * @return array
     */
    public function deleteService(Service $service): array
    {
        Media::delete($service, 'service_image');
        $service->delete();

        return [
            'data' => null,
            'message' => __('Service deleted successfully.'),
        ];
    }
}