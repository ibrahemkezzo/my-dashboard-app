<?php

namespace App\Services;

use App\Facades\Media;
use App\Models\Salon;
use App\Models\SalonSubService;
use App\Repositories\SalonSubServiceRepository;
use Illuminate\Http\UploadedFile;

class SalonSubServiceService
{
    protected $repository;

    public function __construct(SalonSubServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createSalonSubService(Salon $salon, array $data, ?array $images = null): ?SalonSubService
    {
        // Create the salon sub-service relationship
        $this->repository->create($salon, $data);

        // Get the created pivot record
        $pivot = $this->repository->findBySalonAndSubService($salon, $data['sub_service_id']);

        // Handle images if provided
        if ($pivot && $images) {
            $this->addSubServiceImages($pivot, $images);
        }

        return $pivot;
    }

    public function updateSalonSubService(SalonSubService $subService, array $data, ?array $images = null): bool
    {
        // Update the sub-service data
        $updated = $this->repository->update($subService, $data);

        // Handle new images if provided
        if ($updated && $images) {
            $this->addSubServiceImages($subService, $images);
        }

        return $updated;
    }

    public function deleteSalonSubService(SalonSubService $subService): bool
    {
        // Delete associated media first
        if ($subService->media) {
            foreach ($subService->media as $media) {
                Media::deleteSingle($media->id);
            }
        }

        // Delete the sub-service
        return $this->repository->delete($subService);
    }

    public function getSalonSubService(Salon $salon, int $subServiceId): ?SalonSubService
    {
        return $this->repository->find($salon, $subServiceId);
    }

    public function getAllServices(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->getAllServices();
    }

    public function getAllSubServices(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->getAllSubServices();
    }

    public function addSubServiceImages(SalonSubService $pivot, array $images): void
    {
        if (!empty($images)) {
            Media::storeMultiple($images, $pivot, 'sub_service_image', 'salons/services');
        }
    }

    public function deleteSubServiceImage(int $mediaId): void
    {
        Media::deleteSingle($mediaId);
    }

    public function updateSubServiceImage(int $mediaId, UploadedFile $file): void
    {
        Media::updateMedia($file, $mediaId, 'salons/services');
    }

    public function validateSubServiceData(array $data): array
    {
        return [
            'price' => $data['price'] ?? 0,
            'duration' => $data['duration'] ?? 0,
            'materials_used' => $data['materials_used'] ?? null,
            'requirements' => $data['requirements'] ?? null,
            'special_notes' => $data['special_notes'] ?? null,
            'status' => $data['status'] ?? true,
        ];
    }
} 