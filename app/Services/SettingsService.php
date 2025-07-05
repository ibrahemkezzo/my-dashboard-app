<?php

namespace App\Services;

use App\Contracts\SettingsInterface;
use App\Facades\Media;
use App\Models\Service;
use App\Models\Setting;
use App\Services\Storage\SingleColumnStorage;
use Illuminate\Http\UploadedFile;

class SettingsService
{
    protected SettingsInterface $repository;
    protected $defaultGeneralSettings;
    protected $defaultAboutUsSettings;
    protected $defaultContactUsSettings;
    protected $defaultLegalSettings;

    /**
     * SettingsService constructor.
     *
     * @param SettingsInterface $repository
     */
    public function __construct(SettingsInterface $repository)
    {
        $this->repository = $repository;
        $this->defaultGeneralSettings = [
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
            'site_logo' => '',
            'cover_image' => '',
            'favicon' => '',
        ];
        $this->defaultAboutUsSettings = [
            'about_us_title' => '',
            'about_us_description' => '',
            'about_us_vision' => '',
            'about_us_mission' => '',
            'about_us_values' => [],
            'about_us_video_url' => '',
            'about_us_founded_at' => '',
            'about_us_employees_count' => 0,
            'about_us_statistics' => [],
            'about_us_image' => '',
        ];
        $this->defaultContactUsSettings = [
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
        $this->defaultLegalSettings = [
            'terms_description' => '',
            'terms_content' => '',
            'privacy_description' => '',
            'privacy_sections' => [],
            'faq_description' => '',
            'faq_questions' => [],
        ];
    }


    /**
     * Retrieve all general settings with default values.
     *
     * @return array
     */
    public function getGeneralSettings(): array
    {


        return array_merge($this->defaultGeneralSettings, $this->repository->all('general'));
    }

    /**
     * Retrieve all About Us settings with default values.
     *
     * @return array
     */
    public function getAboutUsSettings(): array
    {
        return array_merge($this->defaultAboutUsSettings, $this->repository->all('about_us'));
    }

    /**
     * Retrieve all Contact Us settings with default values.
     *
     * @return array
     */
    public function getContactUsSettings(): array
    {

        return array_merge($this->defaultContactUsSettings, $this->repository->all('contact_us'));
    }

    /**
     * Retrieve all legal/info settings with default values.
     *
     * @return array
     */
    public function getLegalSettings(): array
    {
        return array_merge($this->defaultLegalSettings, $this->repository->all('legal'));
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

        $settings = $this->repository->all('general');
        if($settings == null){
            $data = array_merge($this->defaultGeneralSettings, $data);
        }
        $updatedSettings = [];
        $imageKeys = ['site_logo', 'cover_image', 'favicon'];

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->defaultGeneralSettings) && !in_array($key, $imageKeys)) {
                $updatedSettings[$key] = $this->repository->set($key, $value, 'general');
                // dump($updatedSettings);
            }
        }
        foreach ($imageKeys as $key) {

            if (isset($files[$key]) && $files[$key] instanceof UploadedFile) {
                $setting = $this->repository->getModel($key);

                if ($setting->value) {
                    Media::delete($setting, $key, 'single_column', ['column' => 'value']);
                }
                Media::storeSingle($files[$key], $setting, $key, 'settings', 'single_column', ['column' => 'value']);
                $updatedSettings[$key] = $setting->value;
            }
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


        $settings = $this->repository->all('about_us');
        if($settings == null){
            $data = array_merge($this->defaultAboutUsSettings, $data);
        }
        $updatedSettings = [];
        $imageKey = 'about_us_image';

        foreach ($data as $key => $value) {
            $mappedKey = 'about_us_' . $key;
            if (array_key_exists($key, $this->defaultAboutUsSettings)&& !in_array($key, [$imageKey])) {
                $updatedSettings[$mappedKey] = $this->repository->set($mappedKey, $value, 'about_us');
            }
        }
        // dd($image);

        if ($image) {
           $old =  $this->repository->getModel($imageKey);
           if($old == null){
             $old = $this->repository->set($imageKey, null, 'about_us');
           }

            if($old->value){
                Media::delete($old,'about_us_image','single_column',['column'=>'value']);
            }
            Media::storeSingle($image,$old,'about_us_image','settings','single_column',['column'=>'value']);
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

        $settings = $this->repository->all('contact_us');
        if($settings == null){
            $data = array_merge($this->defaultContactUsSettings, $data);
        }
        $updatedSettings = [];

        foreach ($data as $key => $value) {
            $mappedKey = 'contact_us_' . $key;
            if (array_key_exists($key, $this->defaultContactUsSettings)) {
                $updatedSettings[$mappedKey] = $this->repository->set($mappedKey, $value, 'contact_us');
            }
        }

        return [
            'data' => $updatedSettings,
            'message' => __('Contact Us settings updated successfully.'),
        ];
    }

    /**
     * Update legal/info settings.
     *
     * @param array $data
     * @return array
     */
    public function updateLegalSettings(array $data): array
    {
        $settings = $this->repository->all('legal');
        if ($settings == null) {
            $data = array_merge($this->defaultLegalSettings, $data);
        }
        $updatedSettings = [];
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->defaultLegalSettings)) {
                // Store arrays as JSON
                $updatedSettings[$key] = $this->repository->set($key, is_array($value) ? $value : $value, 'legal');
            }
        }
        return [
            'data' => $updatedSettings,
            'message' => __('Legal settings updated successfully.'),
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
            if ($image) {
                // dd($service->media);
                Media::updateSingle($image,$service,'service_image','service_image','morph',[]);
            }
        } else {
            $service = Service::create($serviceData);
            if ($image) {
                Media::storeSingle($image,$service,'service image','service_image','morph',[]);
            }
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

    public function updateFaqSettings(array $data): array
    {

        // dd($data);
        $updatedSettings = [];
        if(isset($data['faq_description'])) {
            $updatedSettings['faq_description'] = $this->repository->set('faq_description', $data['faq_description'] ?? '', 'legal');
        }

        if(isset($data['faq_questions'])) {
            $old_questions = $this->repository->get('faq_questions');
            foreach($data['faq_questions'] as $i => $updateNewQuestion ){
                // dd($updateNewQuestion['question'] == null);
                if($updateNewQuestion['question'] == null){
                    unset($old_questions[$i]);
                }elseif($i == 0){
                    $lastIndex = array_key_last($old_questions);
                    $old_questions[$lastIndex+1]['question'] =  $updateNewQuestion['question'];
                    $old_questions[$lastIndex+1]['answer'] =  $updateNewQuestion['answer'];
                    $old_questions[$lastIndex+1]['category'] =  $updateNewQuestion['category'];
                }else{
                    $old_questions[$i]['question'] =  $updateNewQuestion['question'];
                    $old_questions[$i]['answer'] =  $updateNewQuestion['answer'];
                    $old_questions[$i]['category'] =  $updateNewQuestion['category'];
                }
            }
            // dd($old_questions);
            $updatedSettings['faq_questions'] = $this->repository->set('faq_questions', $old_questions , 'legal');
        }
        return [
            'data' => $updatedSettings,
            'message' => __('FAQ updated successfully.'),
        ];
    }

    public function updatePrivacySettings(array $data): array
    {
        $updatedSettings = [];
        if(isset($data['privacy_description'])){
            $updatedSettings['privacy_description'] = $this->repository->set('privacy_description', $data['privacy_description'] ?? '', 'legal');
        }
        if(isset($data['privacy_sections'])){
            $oldPrivacy = $this->repository->get('privacy_sections');
            foreach($data['privacy_sections'] as $i => $updateNewPravcy ){
                if($updateNewPravcy['title'] == null){
                    unset($oldPrivacy[$i]);
                }elseif($i == 0){
                    $lastIndex = array_key_last($oldPrivacy);
                    $oldPrivacy[$lastIndex+1]['title'] = $updateNewPravcy['title'];
                    $oldPrivacy[$lastIndex+1]['content'] = $updateNewPravcy['content'];
                }else{
                    $oldPrivacy[$i]['title'] = $updateNewPravcy['title'];
                    $oldPrivacy[$i]['content'] = $updateNewPravcy['content'];
                }
            $oldPrivacy['privacy_sections'] = $this->repository->set('privacy_sections', $oldPrivacy ?? [], 'legal');
            }
        }
        return [
            'data' => $updatedSettings,
            'message' => __('Privacy Policy updated successfully.'),
        ];
    }

    public function updateTermsSettings(array $data): array
    {
        $updatedSettings = [];
        if(isset($data['terms_description'])){
            $updatedSettings['terms_description'] = $this->repository->set('terms_description', $data['terms_description'] ?? '', 'legal');
        }
        if(isset($data['terms_content'])){
            $updatedSettings['terms_content'] = $this->repository->set('terms_content', $data['terms_content'] ?? '', 'legal');
        }
        return [
            'data' => $updatedSettings,
            'message' => __('Terms updated successfully.'),
        ];
    }
}