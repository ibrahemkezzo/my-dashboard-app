<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\StoreSubServiceRequest;
use App\Http\Requests\UpdateSubServiceRequest;
use App\Models\SubService;
use App\Models\Service;
use App\Services\SubServiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller ;
use Illuminate\View\View;

class SubServiceController extends Controller
{
    protected $service;

    public function __construct(SubServiceService $service)
    {
        $this->service = $service;
        $this->middleware(['auth', 'role:super-admin']);
    }

    public function index(): View
    {
        $filters = request()->only(['search', 'service_id', 'status']);
        $subServices = $this->service->list(20, $filters);
        $services = Service::orderBy('order')->get();
        return view('dashboard.sub_services.index', compact('subServices', 'services', 'filters'));
    }

    public function create(): View
    {
        $services = Service::orderBy('order')->get();
        return view('dashboard.sub_services.create', compact('services'));
    }

    public function store(StoreSubServiceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->service->create($data, $request->file('icon_or_image'));
        return redirect()->route('dashboard.sub_services.index')
            ->with('message', ['type' => 'success', 'content' => __('dashboard.saved_successfully')]);
    }

    public function edit(SubService $subService): View
    {
        $services = Service::orderBy('order')->get();
        return view('dashboard.sub_services.edit', compact('subService', 'services'));
    }

    public function update(UpdateSubServiceRequest $request, SubService $subService): RedirectResponse
    {
        $data = $request->validated();
        $this->service->update($subService, $data, $request->file('icon_or_image'));
        return redirect()->route('dashboard.sub_services.index')
            ->with('message', ['type' => 'success', 'content' => __('dashboard.updated_successfully')]);
    }

    public function destroy(SubService $subService): RedirectResponse
    {
        $this->service->delete($subService);
        return redirect()->route('dashboard.sub_services.index')
            ->with('message', ['type' => 'success', 'content' => __('dashboard.deleted_successfully')]);
    }
}