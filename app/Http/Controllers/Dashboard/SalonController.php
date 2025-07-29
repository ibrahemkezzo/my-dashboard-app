<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\StoreSalonRequest;
use App\Http\Requests\UpdateSalonRequest;
use App\Models\Salon;
use App\Models\User;
use App\Models\City;
use App\Models\Service;
use App\Models\SubService;
use App\Services\SalonService;
use App\Services\SalonSubServiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    protected $service;
    protected $salonSubService;

    public function __construct(SalonService $service,SalonSubServiceService $salonSubService)
    {

        $this->service = $service;
        $this->salonSubService = $salonSubService;
        $this->middleware(['auth', 'role:super-admin']);
    }

    public function index(): View
    {
        $filters = request()->only(['search', 'city_id', 'owner_id', 'status']);
        $salons = $this->service->list(20, $filters);
        $cities = City::orderBy('name')->get();
        $owners = User::orderBy('name')->get();

        return view('dashboard.salons.index', compact('salons', 'cities', 'owners', 'filters'));
    }

    public function create()
    {
        // Redirect to step 1 of the wizard
        return redirect()->route('dashboard.salons.create.step1');
    }

    public function createStep1()
    {
        $owners = User::where('type','user')->orderBy('name')->get();
        return view('dashboard.salons.create_step1', compact('owners'));
    }

    public function storeStep1(StoreSalonRequest $request)
    {
        $user = User::findOrFail($request->owner_id);

        $validated = $request->validated();
        $salon = $this->service->create($validated);
        if ($salon) {
            $user->assignRole('salon-manager');
            $user->removeRole('user');
            $user->type = 'salon-manager';
            $user->save();
        }
        if (!$salon) return redirect()->route('dashboard.salons.create.step1');
        $subServices = SubService::with('service')->orderBy('name')->get();
        $allServices = Service::all();
        return view('dashboard.salons.create_step2', compact('salon', 'subServices', 'allServices'));
    }

    public function storeStep2(Request $request , Salon $salon)
    {
        $validated = $request->validate([
            'salon_services' => 'required|array',
            'salon_services.*.service_id' => 'required|exists:services,id',
            'salon_services.*.sub_service_id' => 'required|exists:sub_services,id',
            'salon_services.*.price' => 'nullable|numeric',
            'salon_services.*.duration' => 'nullable|integer',
            'salon_services.*.status' => 'nullable|boolean',
            // 'salon_services.*.materials_used' => 'nullable|string',
            // 'salon_services.*.requirements' => 'nullable|string',
            'salon_services.*.special_notes' => 'nullable|string',
            // 'salon_services.*.images.*' => 'nullable|image|max:2048',
        ]);


         $sync = $this->service->syncSubServices($salon,$validated['salon_services']);
        return redirect()->route('dashboard.salons.index')->with('message', ['type' => 'success', 'content' => __('dashboard.saved_successfully')]);
    }

    public function show(Salon $salon): View
    {
        $salon->load(['owner', 'city', 'subServices.service']);

        // Get salon booking data
        $bookingFilters = request()->only(['search', 'status', 'user_id', 'date_from', 'date_to']);
        $bookings = app(\App\Services\BookingService::class)->getBySalon($salon, 10, $bookingFilters);
        $bookingStatistics = app(\App\Services\BookingService::class)->getStatistics(array_merge($bookingFilters, ['salon_id' => $salon->id]));

        return view('dashboard.salons.show', compact('salon', 'bookings', 'bookingStatistics'));
    }

    public function edit(Salon $salon): View
    {
        $cities = City::orderBy('name')->get();
        $owners = User::orderBy('name')->get();
        $subServices = SubService::with('service')->orderBy('name')->get();
        $salon->load('subServices');
        $allServices = Service::all();

        return view('dashboard.salons.edit', compact('salon', 'cities', 'owners', 'subServices','allServices'));
    }

    public function update(UpdateSalonRequest $request, Salon $salon): RedirectResponse
    {
        $data = $request->validated();
        // dd($data);
        $this->service->update($salon, $data, $request->file('logo'), $request->file('cover_image'));

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $this->service->addGalleryImages($salon, $request->file('gallery_images'));
        }

        return redirect()->route('dashboard.salons.index')
            ->with('message', ['type' => 'success', 'content' => __('dashboard.updated_successfully')]);
    }

    public function destroy(Salon $salon): RedirectResponse
    {
        $this->service->delete($salon);
        return redirect()->route('dashboard.salons.index')
            ->with('message', ['type' => 'success', 'content' => __('dashboard.deleted_successfully')]);
    }
}
