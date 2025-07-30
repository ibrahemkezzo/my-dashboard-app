<?php

namespace App\QueryFilters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SalonFilter
{
    protected $request;
    protected $query;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $query)
    {
        $this->query = $query;
        $this->filterSearch();
        $this->filterCity();
        $this->filterServiceType();
        $this->filterPrice();
        $this->filterOffer();
        $this->filterStatus();
        $this->filterSort();
        return $this->query;
    }

    protected function filterSearch()
    {
        if ($search = $this->request->input('search')) {
            $this->query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%");
            });
        }
    }

    protected function filterCity()
    {
        if ($cityId = $this->request->input('city_id')) {
            $this->query->where('city_id', $cityId);
        }
    }

    protected function filterServiceType()
    {
        if ($serviceType = $this->request->input('service_type')) {
            $this->query->whereHas('subServices', function($q) use ($serviceType) {
                $q->where('name', 'like', "%$serviceType%");
            });
        }
    }

    protected function filterPrice()
    {
        if ($min = $this->request->input('price_min')) {
            $this->query->whereHas('subServices', function($q) use ($min) {
                $q->where('salon_sub_service.price', '>=', $min);
            });
        }
        if ($max = $this->request->input('price_max')) {
            $this->query->whereHas('subServices', function($q) use ($max) {
                $q->where('salon_sub_service.price', '<=', $max);
            });
        }
    }

    protected function filterOffer()
    {
        if ($this->request->boolean('has_offer')) {
            $this->query->where('has_offer', true); // Adjust if your offer logic is different
        }
    }

    protected function filterStatus()
    {
        if (!is_null($this->request->input('status')) && $this->request->input('status') !== '') {
            $this->query->where('status', $this->request->input('status'));
        }
    }

    protected function filterSort()
    {
        $sort = $this->request->input('sort', 'default');
        switch ($sort) {
            case 'lowest-price':
                $this->query->withMin('subServices as min_price', 'salon_sub_service.price')->orderBy('min_price');
                break;
            case 'highest-price':
                $this->query->withMax('subServices as max_price', 'salon_sub_service.price')->orderByDesc('max_price');
                break;
            case 'highest-rating':
                $this->query->orderByDesc('rating');
                break;
            case 'lowest-rating':
                $this->query->orderBy('rating');
                break;
            case 'certified':
                $this->query->orderByDesc('certified'); // Add certified column if needed
                break;
            case 'home-based':
                $this->query->orderByDesc('home_based'); // Add home_based column if needed
                break;
            default:
                $this->query->orderByDesc('created_at');
        }
    }
}
