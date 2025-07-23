<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\FrontStoreSalonRequest;
use App\Http\Requests\StoreSalonRequest;
use Illuminate\Http\Request;
use App\Services\SalonService;
use App\QueryFilters\SalonFilter;
use App\Models\Salon;
use App\Models\Service;
use App\Models\SubService;
use App\Models\User;
use App\Services\SalonSubServiceService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SalonController extends Controller
{

    protected $service;
    protected $salonSubService;

    public function __construct(SalonService $service,SalonSubServiceService $salonSubService)
    {

        $this->service = $service;
        $this->salonSubService = $salonSubService;
        $this->middleware(['auth'])->only(['create','storeStep2','storeStep1']);
    }


    public function index()
    {
        return view('frontend.salons.create_step1');
    }

    /**
     * List salons with filters for AJAX/API or SSR fallback.
     */
    public function list(Request $request)
    {
        $query = Salon::where('status',true)->with(['owner', 'city', 'subServices']);
        $filter = new SalonFilter($request);
        $filteredQuery = $filter->apply($query);

        $salons = $filteredQuery->paginate($request->input('per_page', 12));

        if ($request->ajax()) {
            // Eager load price range and relationships for each salon
            $salons->getCollection()->transform(function ($salon) {
                $salon->price_range = $salon->price_range;
                $salon->city_name = $salon->city->name ?? null;
                $salon->owner_name = $salon->owner->name ?? null;
                // Return both id and name for sub_services
                $salon->sub_services = $salon->subServices->map(function($sub) {
                    return ['id' => $sub->id, 'name' => $sub->name];
                });
                return $salon;
            });
            return response()->json([
                'salons' => $salons->items(),
                'pagination' => (string) $salons->links(),
            ]);
        }

        return view('frontend.salons.list', compact('salons'));
    }

    /**
     * Provide filter data for the frontend salon page.
     */
    public function filters()
    {
        $cities = \App\Models\City::orderBy('name')->get(['id', 'name']);
        $subservices = \App\Models\SubService::orderBy('name')->get(['id', 'name']);
        $minPrice = DB::table('salon_sub_service')->min('price');
        $maxPrice = DB::table('salon_sub_service')->max('price');
        return response()->json([
            'cities' => $cities,
            'subservices' => $subservices,
            'price_min' => $minPrice,
            'price_max' => $maxPrice,
        ]);
    }

    public function create()
    {
        // Redirect to step 1 of the wizard
        // return redirect()->route('dashboard.salons.create.step1');

        return view('frontend.salons.create_step1');
    }

    public function storeStep1(FrontStoreSalonRequest $request)
    {

        $validated = $request->validated();
        // dd($request->all(),$validated);
        $user = Auth::user();
        $validated['owner_id'] = $user->id;
        $validated['status'] = false;
        $salon = $this->service->create($validated);
        // Assign salon-manager role and update type
        if ($salon) {
            $user->assignRole('salon-manager');
            $user->removeRole('user');
            $user->type = 'salon-manager';
            $user->save();
        }
        if (!$salon) return redirect()->route('front.salons.create.step1');
        $subServices = SubService::with('service')->orderBy('name')->get();
        $allServices = Service::all();
        return view('frontend.salons.create_step2', compact('salon', 'subServices', 'allServices'));
    }

    public function storeStep2(Request $request , Salon $salon)
    {
        // dd($request->all());
        $validated = $request->validate([
            'salon_services' => 'required|array',
            'salon_services.*.service_id' => 'required|exists:services,id',
            'salon_services.*.sub_service_id' => 'required|exists:sub_services,id',
            'salon_services.*.price' => 'nullable|numeric',
            'salon_services.*.duration' => 'nullable|integer',
            'salon_services.*.status' => 'nullable|boolean',
            'salon_services.*.materials_used' => 'nullable|string',
            'salon_services.*.requirements' => 'nullable|string',
            'salon_services.*.special_notes' => 'nullable|string',
            'salon_services.*.images.*' => 'nullable|image|max:2048',
        ]);
        // dd($validated);

         $sync = $this->service->syncSubServices($salon,$validated['salon_services']);
        return redirect()->route('front.home')->with('message', ['type' => 'success', 'content' => __('dashboard.saved_successfully')]);
    }

    public function show(Salon $salon){
        $salon->load('subServices','bookings','media','city','owner');
        return view('frontend.salons.show',compact('salon'));
    }

    public function manager(){
        return view('frontend.salons.manager');
    }
}
