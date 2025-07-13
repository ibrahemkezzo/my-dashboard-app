<?php

namespace App\Repositories;

use App\Models\Salon;
use App\Models\SalonSubService;
use App\Models\SubService;

class SalonSubServiceRepository
{
    public function create(Salon $salon, array $data): void
    {
        $salon->subServices()->attach($data['sub_service_id'], [
            'price' => $data['price'] ?? 0,
            'duration' => $data['duration'] ?? 0,
            'materials_used' => $data['materials_used'] ?? null,
            'requirements' => $data['requirements'] ?? null,
            'special_notes' => $data['special_notes'] ?? null,
            'status' => $data['status'] ?? true,
        ]);
    }

    public function find(Salon $salon, int $subServiceId): ?SalonSubService
    {
        return $salon->subServices()
            ->wherePivot('sub_service_id', $subServiceId)
            ->first()?->pivot;
    }

    public function update(SalonSubService $subService, array $data): bool
    {
        return $subService->update([
            'price' => $data['price'] ?? $subService->price,
            'duration' => $data['duration'] ?? $subService->duration,
            'materials_used' => $data['materials_used'] ?? $subService->materials_used,
            'requirements' => $data['requirements'] ?? $subService->requirements,
            'special_notes' => $data['special_notes'] ?? $subService->special_notes,
            'status' => $data['status'] ?? $subService->status,
        ]);
    }

    public function delete(SalonSubService $subService): bool
    {
        return $subService->delete();
    }

    public function findBySalonAndSubService(Salon $salon, int $subServiceId): ?SalonSubService
    {
        return $salon->subServices()
            ->where('sub_service_id', $subServiceId)
            ->first()?->pivot;
    }

    public function getAllServices(): \Illuminate\Database\Eloquent\Collection
    {
        return \App\Models\Service::all();
    }

    public function getAllSubServices(): \Illuminate\Database\Eloquent\Collection
    {
        return SubService::with('service')->orderBy('name')->get();
    }
}