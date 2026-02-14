<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Salon;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    protected $service;

    public function __construct(SubscriptionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
    
        $salons = $this->service->getSubscriptions($request);
        $statistics = $this->service->getStatistics($request);
        // dd($statistics);
        $filters = $request->only(['search', 'status', 'period']);

        return view('dashboard.subscriptions.index', compact('salons', 'statistics', 'filters'));
    }

    public function assignForm(Salon $salon)
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();
        return view('dashboard.subscriptions.assign', compact('salon', 'plans'));
    }

    public function assign(Request $request, Salon $salon)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'paid_amount' => 'nullable|numeric|min:0',
            'note' => 'nullable|string|max:500',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $this->service->assignOrRenewManual($salon, $plan, $request->paid_amount, $request->note);

        return redirect()->route('dashboard.subscriptions.index')->with('success', 'تم اسناد/تجديد الاشتراك يدويًا بنجاح');
    }

    public function suspend(Subscription $subscription)
    {
        $this->service->suspend($subscription);
        return back()->with('success', 'تم إيقاف الاشتراك');
    }
    public function activate(Subscription $subscription)
    {
        $this->service->activate($subscription);
        return back()->with('success', 'تم إعادة تفعيل الاشتراك بنجاح');
    }
    public function updateEndDate(Request $request, Subscription $subscription)
    {
        $request->validate(['end_date' => 'required|date']);
        $this->service->updateEndDate($subscription, Carbon::parse($request->end_date));
        return back()->with('success', 'تم تحديث تاريخ الانتهاء');
    }

    public function history(Salon $salon)
    {
        $histories = $salon->subscription?->histories()->latest()->get() ?? collect();
        $payments = $salon->subscription?->payments()->latest()->get() ?? collect();

        return view('dashboard.subscriptions.show', compact('salon', 'histories', 'payments'));
    }
}
