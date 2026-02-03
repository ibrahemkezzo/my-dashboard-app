<?php

namespace App\Services;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriptionPlanService
{
    public function getFilteredPlans(Request $request): LengthAwarePaginator
    {
        $filters = $request->only(['search', 'is_active']);

        return SubscriptionPlan::query()
            ->when($filters['search'] ?? false, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when(isset($filters['is_active']), function ($query, $is_active) {
                $query->where('is_active', $is_active);
            })
            ->paginate(10)
            ->withQueryString();
    }

    public function create(array $data): SubscriptionPlan
    {
        return SubscriptionPlan::create($data);
    }

    public function update($id, array $data): SubscriptionPlan
    {
        $plan = SubscriptionPlan::find($id);
        $plan->update($data);
        return $plan;
    }

    public function delete($id): void
    {
        $plan = SubscriptionPlan::find($id);
        $plan->delete();
    }
}
