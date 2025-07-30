<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Requests\StoreSalonSubServiceRequest;
use App\Http\Requests\UpdateSalonSubServiceRequest;
use App\Models\Salon;
use App\Models\SalonSubService;
use App\Services\SalonSubServiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class SalonSubServiceController extends Controller
{
    protected $salonSubServiceService;

    public function __construct(SalonSubServiceService $salonSubServiceService)
    {
        $this->salonSubServiceService = $salonSubServiceService;
        $this->middleware(['auth', 'role:super-admin']);
    }

    public function create(Salon $salon): View
    {
        $subServices = $this->salonSubServiceService->getAllSubServices();
        $allServices = $this->salonSubServiceService->getAllServices();

        return view('dashboard.salons.sub_services.create', compact('salon', 'subServices', 'allServices'));
    }

    public function store(StoreSalonSubServiceRequest $request, Salon $salon): RedirectResponse
    {
        $validatedData = $request->validated();
        $images = $request->file('images');

        $this->salonSubServiceService->createSalonSubService($salon, $validatedData, $images);

        return redirect()->route('dashboard.salons.show', $salon)
            ->with('message', ['type' => 'success', 'content' => __('dashboard.service_added_successfully')]);
    }

    public function show(Salon $salon, SalonSubService $subService): View
    {
        $subService->load(['media', 'subService.service']);

        return view('dashboard.salons.sub_services.show', compact('salon', 'subService'));
    }

    public function edit(Salon $salon, SalonSubService $subService): View
    {
        $subService->load(['media', 'subService.service']);
        $subServices = $this->salonSubServiceService->getAllSubServices();
        $allServices = $this->salonSubServiceService->getAllServices();

        return view('dashboard.salons.sub_services.edit', compact('salon', 'subService', 'subServices', 'allServices'));
    }

    public function update(UpdateSalonSubServiceRequest $request, Salon $salon, SalonSubService $subService): RedirectResponse
    {
        $validatedData = $request->validated();
        $images = $request->file('images');

        $this->salonSubServiceService->updateSalonSubService($subService, $validatedData, $images);

        return redirect()->route('dashboard.salons.sub-services.show', [$salon, $subService])
            ->with('message', ['type' => 'success', 'content' => __('dashboard.service_updated_successfully')]);
    }

    public function destroy(Salon $salon, SalonSubService $subService): RedirectResponse
    {
        $this->salonSubServiceService->deleteSalonSubService($subService);

        return redirect()->route('dashboard.salons.show', $salon)
            ->with('message', ['type' => 'success', 'content' => __('dashboard.service_deleted_successfully')]);
    }
}