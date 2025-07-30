<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\UpdateAboutUsSettingsRequest;
use App\Http\Requests\UpdateContactUsSettingsRequest;
use App\Http\Requests\UpdateGeneralSettingsRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\UpdateFaqSettingsRequest;
use App\Http\Requests\UpdatePrivacySettingsRequest;
use App\Http\Requests\UpdateTermsSettingsRequest;

class SettingsController extends Controller
{
    protected SettingsService $settingsService;

    /**
     * SettingsController constructor.
     *
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
        $this->middleware(['auth', 'role:super-admin']);
    }

    /**
     * Display the settings management page.
     *
     * @return View
     */
    public function index(): View
    {
        $generalSettings = $this->settingsService->getGeneralSettings();
        $aboutUsSettings = $this->settingsService->getAboutUsSettings();
        $contactUsSettings = $this->settingsService->getContactUsSettings();
        $legalSettings = $this->settingsService->getLegalSettings();
        $services = Service::orderBy('order')->get();

        return view('dashboard.settings.web-site', compact(
            'generalSettings',
            'aboutUsSettings',
            'contactUsSettings',
            'legalSettings',
            'services'
        ));
    }

    /**
     * Update general site settings.
     *
     * @param UpdateGeneralSettingsRequest $request
     * @return RedirectResponse
     */
    public function updateGeneral(UpdateGeneralSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $files = array_filter([
            'site_logo' => $request->file('site_logo'),
            'cover_image' => $request->file('cover_image'),
            'favicon' => $request->file('favicon'),
        ]);

        $response = $this->settingsService->updateGeneralSettings($data, $files);

        return Redirect::route('dashboard.settings.index')
            ->with('message', [
                    'type' => 'success',
                    'content' => __('updated completed successfully!')]);
    }

    /**
     * Update About Us settings.
     *
     * @param UpdateAboutUsSettingsRequest $request
     * @return RedirectResponse
     */
    public function updateAboutUs(UpdateAboutUsSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $response = $this->settingsService->updateAboutUsSettings($data, $request->file('image'));

        return Redirect::route('dashboard.settings.index')
            ->with('message', [
                    'type' => 'success',
                    'content' => __('updated completed successfully!')]);
    }

    /**
     * Update Contact Us settings.
     *
     * @param UpdateContactUsSettingsRequest $request
     * @return RedirectResponse
     */
    public function updateContactUs(UpdateContactUsSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $response = $this->settingsService->updateContactUsSettings($data);

        return Redirect::route('dashboard.settings.index')
            ->with('message', [
                    'type' => 'success',
                    'content' => __('updated completed successfully!')]);
    }

    /**
     * Store a new service.
     *
     * @param UpdateServiceRequest $request
     * @return RedirectResponse
     */
    public function storeService(UpdateServiceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $response = $this->settingsService->updateService($data, $request->file('image'));

        return Redirect::route('dashboard.settings.index')
            ->with('message', [
                    'type' => 'success',
                    'content' => __('saved service successfully!')]);
    }

    /**
     * Update an existing service.
     *
     * @param UpdateServiceRequest $request
     * @param Service $service
     * @return RedirectResponse
     */
    public function updateService(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $data = $request->validated();
        $response = $this->settingsService->updateService($data, $request->file('image'), $service);

        return Redirect::route('dashboard.settings.index')
            ->with('message', [
                    'type' => 'success',
                    'content' => __('updated service successfully!')]);
    }

    /**
     * Delete a service.
     *
     * @param Service $service
     * @return RedirectResponse
     */
    public function destroyService(Service $service): RedirectResponse
    {
        $response = $this->settingsService->deleteService($service);

        return Redirect::route('dashboard.settings.index')
            ->with('message', [
                    'error' => 'success',
                    'content' => __('dleted sevice successfully!')]);
    }

    /**
     * Update FAQ settings.
     */
    public function updateFaqSettings(UpdateFaqSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->settingsService->updateFaqSettings($data);
        return Redirect::route('dashboard.settings.index', ['#' => 'faq'])
            ->with('message', [
                'type' => 'success',
                'content' => __('FAQ updated successfully!')
            ]);
    }

    /**
     * Update Privacy Policy settings.
     */
    public function updatePrivacySettings(UpdatePrivacySettingsRequest $request): RedirectResponse
    {
        // $data = $request->validated();
        $data = $request->all();
        // dd($data);
        $this->settingsService->updatePrivacySettings($data);
        return Redirect::route('dashboard.settings.index', ['#' => 'privacy'])
            ->with('message', [
                'type' => 'success',
                'content' => __('Privacy Policy updated successfully!')
            ]);
    }

    /**
     * Update Terms settings.
     */
    public function updateTermsSettings(UpdateTermsSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->settingsService->updateTermsSettings($data);
        return Redirect::route('dashboard.settings.index', ['#' => 'terms'])
            ->with('message', [
                'type' => 'success',
                'content' => __('Terms updated successfully!')
            ]);
    }
}
