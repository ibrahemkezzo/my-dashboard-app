<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\FrontUpdaeteSalonRequest;
use App\Models\Salon;
use App\Models\SalonSubService;
use App\Models\Booking;
use App\Notifications\BookingStatusUpdatedNotification;
use App\Services\SalonService;
use App\Services\SalonSubServiceService;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Notification;

class SalonManagerController extends Controller
{
    protected $salonService;
    protected $salonSubServiceService;
    protected $bookingService;

    public function __construct(SalonService $salonService, SalonSubServiceService $salonSubServiceService, BookingService $bookingService)
    {
        $this->middleware(['auth']);
        $this->salonService = $salonService;
        $this->salonSubServiceService = $salonSubServiceService;
        $this->bookingService = $bookingService;
    }

    // Main manager page (tabs)
    public function index(Request $request)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $tab = $request->get('tab', 'info');
        $statistics = $this->bookingService->getStatistics(['salon_id' => $salon->id]);
        $bookings = $this->bookingService->getBySalon($salon, 100, []);
        $services = $salon->subServices()->with('service')->get();
        return view('frontend.salons.manager.index', compact('salon', 'tab', 'statistics', 'bookings', 'services'));
    }

    // Update salon info
    public function updateInfo(FrontUpdaeteSalonRequest $request)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $data = $request->validated();
        $this->salonService->update($salon, $data, $request->file('logo'), $request->file('cover_image') , $request->file('license_document'));
        return redirect()->route('front.profile.salon.manager', ['tab' => 'info'])->with('message', ['type' => 'success', 'content' => __('تم تحديث بيانات الصالون')]);
    }

    // Add a new service
    public function addService(Request $request)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'sub_service_id' => 'required|exists:sub_services,id',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
            'status' => 'nullable|boolean',
            // 'materials_used' => 'nullable|string|max:1000',
            // 'requirements' => 'nullable|string|max:1000',
            'special_notes' => 'nullable|string|max:1000',
            // 'images.*' => 'nullable|image|max:2048',
        ]);
        // $this->salonSubServiceService->createSalonSubService($salon, $data, $request->file('images'));
        $this->salonSubServiceService->createSalonSubService($salon, $data);
        return redirect()->route('front.profile.salon.manager', ['tab' => 'services'])->with('message', ['type' => 'success', 'content' => __('تمت إضافة الخدمة')]);
    }

    // View service details (with images)
    public function viewService($subServiceId)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $pivot = $salon->subServices()->wherePivot('id', $subServiceId)->firstOrFail();
        $pivotModel = $salon->subServices()->wherePivot('id', $subServiceId)->first()->pivot;
        $media = $pivotModel->media ?? collect();
        return view('frontend.salons.manager._service_view', [
            'salon' => $salon,
            'service' => $pivot,
            'pivot' => $pivotModel,
            'media' => $media,
        ]);
    }

    // Edit service details
    public function editService(Request $request, $subServiceId)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $pivot = $salon->subServices()->wherePivot('id', $subServiceId)->firstOrFail()->pivot;
        $data = $request->validate([
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
            'status' => 'nullable|boolean',
            'materials_used' => 'nullable|string|max:1000',
            'requirements' => 'nullable|string|max:1000',
            'special_notes' => 'nullable|string|max:1000',
        ]);
        app(\App\Services\SalonSubServiceService::class)->updateSalonSubService($pivot, $data);
        return back()->with('message', ['type' => 'success', 'content' => 'تم تحديث الخدمة بنجاح']);
    }

    // Add image to service
    public function addServiceImage(Request $request, $subServiceId)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $pivot = $salon->subServices()->wherePivot('id', $subServiceId)->firstOrFail()->pivot;
        $request->validate([
            'images.*' => 'required|image|max:4096',
        ]);
        if ($request->hasFile('images')) {
            app(\App\Services\SalonSubServiceService::class)->addSubServiceImages($pivot, $request->file('images'));
        }
        return back()->with('message', ['type' => 'success', 'content' => 'تمت إضافة الصور للخدمة']);
    }

    // Delete image from service
    public function deleteServiceImage($subServiceId, $mediaId)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $pivot = $salon->subServices()->wherePivot('id', $subServiceId)->firstOrFail()->pivot;
        $media = $pivot->media()->findOrFail($mediaId);
        \App\Facades\Media::deleteSingle($mediaId);
        return back()->with('message', ['type' => 'success', 'content' => 'تم حذف صورة الخدمة']);
    }

    // Delete a service
    public function deleteService($subServiceId)
    {
        $user = Auth::user();
        $salon = $user->salon;
        // dd($salon);
        if (!$salon) abort(404);
        $pivot = SalonSubService::findOrFail($subServiceId);
        // dd($pivot,$subServiceId);
        if (!$pivot) abort(404);
        $this->salonSubServiceService->deleteSalonSubService($pivot);
        return redirect()->route('front.profile.salon.manager', ['tab' => 'services'])->with('message', ['type' => 'success', 'content' => __('تم حذف الخدمة')]);
    }

    // List bookings (for AJAX or partial reload)
    public function listBookings(Request $request)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $filters = $request->only(['status', 'date_from', 'date_to']);
        $bookings = $this->bookingService->getBySalon($salon, 100, $filters);
        $statistics = $this->bookingService->getStatistics(['salon_id' => $salon->id]);
        return view('frontend.salons.manager._bookings', compact('bookings', 'statistics'));
    }

    // Booking actions (confirm, reject, cancel, modify)
    public function bookingAction(Request $request, Booking $booking)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        if ($booking->salon_id !== $salon->id) abort(403);
        $action = $request->input('action');
        switch ($action) {
            case 'confirm':
                $this->bookingService->salonConfirmBooking($booking, [
                    'action' => 'confirm',
                    'salon_notes' => $request->input('salon_notes'),
                ]);
                Notification::send($booking->user, new BookingStatusUpdatedNotification($booking, 'confirm'));

                break;
            case 'modify':
                $this->bookingService->salonConfirmBooking($booking, [
                    'action' => 'modify',
                    'salon_proposed_datetime' => $request->input('salon_proposed_datetime'),
                    'salon_proposed_price' => $request->input('salon_proposed_price'),
                    'salon_proposed_duration' => $request->input('salon_proposed_duration'),
                    'salon_modification_reason' => $request->input('salon_modification_reason'),
                    'salon_notes' => $request->input('salon_notes'),
                ]);
                Notification::send($booking->user, new BookingStatusUpdatedNotification($booking, 'modify'));
                break;
            case 'reject':
                $this->bookingService->rejectBooking($booking, $request->input('rejection_reason'));
                Notification::send($booking->user, new BookingStatusUpdatedNotification($booking, 'rejected'));
                break;
            case 'cancel':
                $this->bookingService->cancelBooking($booking, $request->input('cancellation_reason'));
                Notification::send($booking->user, new BookingStatusUpdatedNotification($booking, 'cancel'));
                break;
            case 'completed':
                $this->bookingService->markBookingCompleted($booking);
                break;
        }
        return redirect()->route('front.profile.salon.manager', ['tab' => 'bookings'])->with('message', ['type' => 'success', 'content' => __('تم تحديث حالة الحجز')]);
    }

    // Add gallery images
    public function addGalleryImage(Request $request)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $request->validate([
            'gallery_images.*' => 'required|image|max:4096',
        ]);
        if ($request->hasFile('gallery_images')) {
            app(\App\Services\SalonService::class)->addGalleryImages($salon, $request->file('gallery_images'));
        }
        return back()->with('message', ['type' => 'success', 'content' => 'تمت إضافة الصور بنجاح']);
    }

    // Delete a gallery image
    public function deleteGalleryImage($mediaId)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $media = $salon->media()->findOrFail($mediaId);
        \App\Facades\Media::deleteSingle($mediaId);
        return back()->with('message', ['type' => 'success', 'content' => 'تم حذف الصورة بنجاح']);
    }

    // Update/replace a gallery image
    public function updateGalleryImage(Request $request, $mediaId)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $request->validate([
            'image' => 'required|image|max:4096',
        ]);
        $media = $salon->media()->findOrFail($mediaId);
        \App\Facades\Media::updateMedia($request->file('image'), $mediaId, 'salons/gallery');
        return back()->with('message', ['type' => 'success', 'content' => 'تم تحديث الصورة بنجاح']);
    }
}
