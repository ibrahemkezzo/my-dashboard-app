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
use App\Services\SubscriptionService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Notification;

class SalonManagerController extends Controller
{
    protected $salonService;
    protected $salonSubServiceService;
    protected $bookingService;
    protected $subscriptionService;

    public function __construct(SalonService $salonService, SalonSubServiceService $salonSubServiceService, BookingService $bookingService,SubscriptionService $subscriptionService)
    {
        $this->middleware(['auth']);
        $this->salonService = $salonService;
        $this->salonSubServiceService = $salonSubServiceService;
        $this->bookingService = $bookingService;
        $this->subscriptionService = $subscriptionService;
    }

    // Main manager page (tabs)
    public function index(Request $request)
    {
        $user = Auth::user();
        $salon = $user->salon()->with(['subscription.plan', 'city', 'owner'])->first();
        if (!$salon) abort(404);
        $tab = $request->get('tab', 'info');
        $statistics = $this->bookingService->getStatistics(['salon_id' => $salon->id]);
        $bookings = $this->bookingService->getBySalon($salon, 100, []);
        $services = $salon->subServices()->with('service')->get();
        $visibleHistory = $this->subscriptionService->getVisibleHistory($salon);
        return view('frontend.salons.manager.index', compact('salon', 'tab', 'statistics', 'bookings', 'services','visibleHistory'));
    }

    // Update salon info
    public function updateInfo(FrontUpdaeteSalonRequest $request)
    {
        $user = Auth::user();
        $salon = $user->salon;
        if (!$salon) abort(404);
        $data = $request->validated();
        $this->salonService->update($salon, $data, $request->file('logo'), $request->file('cover_image'), $request->file('license_document'));
        return redirect()->route('front.profile.salon.manager', ['tab' => 'info'])->with('message', ['type' => 'success', 'content' => __('تم تحديث بيانات الصالون')]);
    }

     /**
     * Add a new service to the salon.
     */
    public function addService(Request $request)
    {
        try {
            $user = Auth::user();
            $salon = $user->salon;
            if (!$salon) {
                abort(404);
            }

            $data = $request->validate([
                'service_id' => 'required|exists:services,id',
                'sub_service_id' => 'required|exists:sub_services,id',
                'price' => 'required|numeric|min:0',
                'max_price' => 'required|numeric|min:0|gt:price',
                'duration' => 'required|integer|min:0',
                'status' => 'nullable|boolean',
                'special_notes' => 'nullable|string|max:1000',
            ]);

            $this->salonSubServiceService->createSalonSubService($salon, $data);

            return redirect()->route('front.profile.salon.manager', ['tab' => 'services'])
                ->with('message', ['type' => 'success', 'content' => __('تمت إضافة الخدمة')]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // معالجة أخطاء التحقق
            $errors = $e->validator->errors()->all();
            $errorMessage = implode(' ', $errors);

            return back()->with('message', ['type' => 'error', 'content' => $errorMessage]);
        } catch (QueryException $e) {
            // معالجة أخطاء قاعدة البيانات (مثل قيد unique)
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return back()->with('message', [
                    'type' => 'error',
                    'content' => 'هذه الخدمة مضافة مسبقًا لهذا الصالون.'
                ]);
            }

            // تسجيل الخطأ للتتبع (اختياري)
            \Illuminate\Support\Facades\Log::error('Failed to add service: ' . $e->getMessage(), [
                'salon_id' => $salon->id,
                'sub_service_id' => $request->input('sub_service_id'),
            ]);

            // إرجاع رسالة خطأ عامة إذا لم يكن الخطأ متعلقًا بـ unique
            return back()->with('message', [
                'type' => 'error',
                'content' => 'حدث خطأ أثناء إضافة الخدمة. حاول مرة أخرى.'
            ]);
        }
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

        try {
            $user = Auth::user();
            $salon = $user->salon;
            if (!$salon) {
                abort(404);
            }

            $pivot = $salon->subServices()->wherePivot('id', $subServiceId)->firstOrFail()->pivot;

            $data = $request->validate([
                'price' => 'required|numeric|min:0',
                'max_price' => 'required|numeric|min:0|gt:price',
                'duration' => 'required|integer|min:0',
                'status' => 'nullable|boolean',
                'materials_used' => 'nullable|string|max:1000',
                'requirements' => 'nullable|string|max:1000',
                'special_notes' => 'nullable|string|max:1000',
            ], [
                'price.required' => 'السعر مطلوب.',
                'price.numeric' => 'يجب أن يكون السعر رقمًا.',
                'price.min' => 'يجب أن يكون السعر أكبر من أو يساوي 0.',
                'max_price.required' => 'السعر الأقصى مطلوب.',
                'max_price.numeric' => 'يجب أن يكون السعر الأقصى رقمًا.',
                'max_price.min' => 'يجب أن يكون السعر الأقصى أكبر من أو يساوي 0.',
                'max_price.gt' => 'يجب أن يكون السعر الأقصى أكبر من السعر الأدنى.',
                'duration.required' => 'المدة مطلوبة.',
                'duration.integer' => 'يجب أن تكون المدة عددًا صحيحًا.',
                'duration.min' => 'يجب أن تكون المدة أكبر من أو تساوي 0.',
                'materials_used.max' => 'المواد المستخدمة يجب ألا تتجاوز 1000 حرف.',
                'requirements.max' => 'المتطلبات يجب ألا تتجاوز 1000 حرف.',
                'special_notes.max' => 'الملاحظات الخاصة يجب ألا تتجاوز 1000 حرف.',
            ]);

            app(\App\Services\SalonSubServiceService::class)->updateSalonSubService($pivot, $data);

            return back()->with('message', ['type' => 'success', 'content' => 'تم تحديث الخدمة بنجاح']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // استخراج رسائل الأخطاء من الاستثناء
            $errors = $e->validator->errors()->all();
            $errorMessage = implode(' ', $errors); // دمج جميع الأخطاء في نص واحد

            return back()->with('message', ['type' => 'error', 'content' => $errorMessage]);
        }
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
