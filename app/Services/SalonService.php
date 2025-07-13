<?php

namespace App\Services;

use App\Facades\Media;
use App\Models\Salon;
use App\Models\SalonSubService;
use App\Repositories\SalonRepository;
use Illuminate\Http\UploadedFile;

class SalonService
{
    protected $repository;

    public function __construct(SalonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list($perPage = 15, $filters = [])
    {
        return $this->repository->paginate($perPage, $filters);
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        if (isset($data['logo'])) {
            $logo = $data['logo'];
            $data['logo'] = $logo->store('salons/logos', 'public');
        }

        if (isset($data['cover_image'])) {
            $coverImage = $data['cover_image'];
            $data['cover_image'] = $coverImage->store('salons/covers', 'public');
        }
        $salon = $this->repository->create($data);
        if (isset($data['gallery_images'])) {
            $galleryImages = $data['gallery_images'];
            $this->addGalleryImages($salon, $galleryImages);
            unset($data['gallery_images']);
        }

        return $salon;
    }

    public function update(Salon $salon, array $data, ?UploadedFile $logo = null, ?UploadedFile $coverImage = null)
    {
        if ($logo) {
            Media::delete($salon,'sub_service','single_column',['column'=>'logo']);
            Media::storeSingle($logo,$salon,'sub_service','salons/logos','single_column',['column'=>'logo']);
        }

        if ($coverImage) {
            Media::delete($salon,'sub_service','single_column',['column'=>'cover_image']);
            Media::storeSingle($coverImage,$salon,'sub_service','salons/covers','single_column',['column'=>'cover_image']);
        }

        return $this->repository->update($salon, $data);
    }

    public function delete(Salon $salon)
    {
        return $this->repository->delete($salon);
    }

    public function syncSubServices(Salon $salon, array $salonServices)
    {
        $syncData = $this->transformSalonServicesForSync($salonServices);
        $newServices = $this->repository->syncSubServices($salon, $syncData);

        $salonSubServiceService = app(SalonSubServiceService::class);
        foreach ($salonServices as  $subService) {
            if ($subService['images']) {
                $pivot = $salonSubServiceService->getSalonSubService($salon, $subService['sub_service_id']);
                if ($pivot) {
                    $salonSubServiceService->addSubServiceImages($pivot, $subService['images']);
                }
            }
        }
        return $newServices;
    }

    private function transformSalonServicesForSync(array $salonServices): array
    {
        // dd($salonServices);
        $syncData = [];
        foreach ($salonServices as $i => $row) {

            // dd($row['sub_service_id']);
            if (!empty($row['sub_service_id'])) {
                $syncData[$row['sub_service_id']] = [
                    'price' => $row['price'] ?? 0,
                    'duration' => $row['duration'] ?? 0,
                    'materials_used' => $row['materials_used'] ?? null,
                    'requirements' => $row['requirements'] ?? null,
                    'special_notes' => $row['special_notes'] ?? null,
                    'status' => $row['status'] ?? true,
                ];
            }
            // dd($row);
        }
        return $syncData;
    }

    /**
     * Handle salon gallery images (store multiple)
     */
    public function addGalleryImages(Salon $salon, array $images)
    {
        if (!empty($images)) {
            Media::storeMultiple($images, $salon, 'gallery_image', 'salons/gallery');
        }
    }

    /**
     * Delete a single gallery image by media ID
     */
    public function deleteGalleryImage(int $mediaId)
    {
        Media::deleteSingle($mediaId);
    }

    /**
     * Update a single gallery image by media ID
     */
    public function updateGalleryImage(int $mediaId, $file)
    {
        Media::updateMedia($file, $mediaId, 'salons/gallery');
    }
}