<?php

namespace App\Repositories;

use App\Models\Salon;

class SalonRepository
{
    public function all()
    {
        return Salon::with(['owner', 'city'])->orderBy('created_at', 'desc')->get();
    }

    public function paginate($perPage = 15, $filters = [])
    {
        $query = Salon::with(['owner', 'city']);

        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('address', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['city_id'])) {
            $query->where('city_id', $filters['city_id']);
        }

        if (!empty($filters['owner_id'])) {
            $query->where('owner_id', $filters['owner_id']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function find($id)
    {
        return Salon::with(['owner', 'city', 'subServices.service'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Salon::create($data);
    }

    public function update(Salon $salon, array $data)
    {
        $salon->update($data);
        return $salon;
    }

    public function delete(Salon $salon)
    {
        return $salon->delete();
    }

    public function syncSubServices(Salon $salon, array $subServicesData)
    {
        return $salon->subServices()->sync($subServicesData);
    }
}