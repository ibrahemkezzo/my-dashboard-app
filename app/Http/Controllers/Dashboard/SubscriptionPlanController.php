<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionPlanRequest;
use App\Http\Requests\UpdateSubscriptionPlanRequest;
use App\Models\SubscriptionPlan;
use App\Services\SubscriptionPlanService;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    protected $service;

    public function __construct(SubscriptionPlanService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $plans = $this->service->getFilteredPlans($request);
        $filters = $request->only(['search', 'is_active']);

        return view('dashboard.subscription_plans.index', compact('plans', 'filters'));
    }

    public function create()
    {
        return view('dashboard.subscription_plans.create');
    }

    public function store(StoreSubscriptionPlanRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('dashboard.subscription-plans.index')->with('success', 'تم إضافة الخطة بنجاح');
    }

    public function edit($id)
    {
        $plan = SubscriptionPlan::where('id',$id)->first();
        return view('dashboard.subscription_plans.edit', compact('plan'));
    }

    public function update(UpdateSubscriptionPlanRequest $request, $id)
    {

        $this->service->update($id, $request->validated());

        return redirect()->route('dashboard.subscription-plans.index')->with('success', 'تم تحديث الخطة بنجاح');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('dashboard.subscription-plans.index')->with('success', 'تم حذف الخطة بنجاح');
    }
}
