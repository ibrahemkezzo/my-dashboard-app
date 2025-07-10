<?php

namespace App\Repositories;

use App\Models\Service;
use App\Models\SubService;

class SubServiceRepository
{
    public function all()
    {
        return SubService::with('service')->orderBy('order')->get();
    }

    public function paginate($perPage = 15, $filters = [])
    {
        $query = SubService::with('service');
        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }
        if (!empty($filters['service_id'])) {
            $query->where('service_id', $filters['service_id']);
        }
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }
        return $query->orderBy('order')->paginate($perPage);
    }

    public function find($id)
    {
        return SubService::with('service')->findOrFail($id);
    }

    public function create(array $data)
    {
        return SubService::create($data);
    }

    public function update(SubService $subService, array $data)
    {
        $subService->update($data);
        return $subService;
    }

    public function delete(SubService $subService)
    {
        return $subService->delete();
    }
    public function allService()
    {
        $services = Service::all()->load('sub_services');
        return $services;
    }
}