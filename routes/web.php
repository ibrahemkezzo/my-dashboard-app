<?php

use App\Http\Controllers\Abilities\PermissionController;
use App\Http\Controllers\Abilities\RoleController;
use App\Http\Controllers\Abilities\UserController;
use App\Http\Controllers\Dashboard\AppointmentController;
use App\Http\Controllers\Dashboard\BookingController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\VisitTimeController;
use App\Http\Controllers\Dashboard\SubServiceController;
use App\Http\Controllers\Dashboard\SalonController;
use App\Http\Controllers\Dashboard\SalonSubServiceController;
use App\Http\Controllers\Files\FileManagerController;
use App\Http\Controllers\Files\MediaController;
use App\Http\Controllers\Frontend\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/laravel', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/jetstream/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



//route for dashboard

Route::middleware(['auth'])->group(function () {

});

Route::group([
    'middleware' => ['auth', 'role:super-admin'],
    'as'=>'dashboard.',  //pefor(pre) each name route
    'prefix'=>'dashboard', //pefor(pre) each path route
],function () {

    //route for dashboard main page

    Route::get('/',[DashboardController::class,'index'])->name('index');

    // route for roles

    Route::resource('roles', RoleController::class);
    Route::post('roles/{id}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.assign-permissions');

    //route for permissions

    Route::resource('permissions', PermissionController::class);

    //route for manage users

    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::resource('users', UserController::class);
    Route::get('users/{user}/roles', [UserController::class, 'editRoles'])->name('users.editRoles');
    Route::post('users/{user}/roles', [UserController::class, 'assignRoles'])->name('users.assign-roles');
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    //route for file manager

    Route::post('media/single', [MediaController::class, 'storeSingle'])->name('media.storeSingle');
    Route::post('media/multiple', [MediaController::class, 'storeMultiple'])->name('media.storeMultiple');
    Route::put('media/{mediaId}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('media/{mediaId}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::get('file-manager', [FileManagerController::class, 'index'])->name('file-manager.media');
    Route::delete('file-manager/{media}', [FileManagerController::class, 'destroy'])->name('file-manager.destroy');
    Route::get('file-manager/folder/{folder}', [FileManagerController::class, 'showFolder'])->name('file-manager.folder');

    //route for settings website

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.updateGeneral');
    Route::post('settings/about-us', [SettingsController::class, 'updateAboutUs'])->name('settings.updateAboutUs');
    Route::post('settings/contact-us', [SettingsController::class, 'updateContactUs'])->name('settings.updateContactUs');
    Route::post('settings/services', [SettingsController::class, 'storeService'])->name('settings.storeService');
    Route::put('settings/services/{service}', [SettingsController::class, 'updateService'])->name('settings.updateService');
    Route::delete('settings/services/{service}', [SettingsController::class, 'destroyService'])->name('settings.destroyService');
    Route::post('settings/faq', [SettingsController::class, 'updateFaqSettings'])->name('settings.updateFaq');
    Route::post('settings/privacy', [SettingsController::class, 'updatePrivacySettings'])->name('settings.updatePrivacy');
    Route::post('settings/terms', [SettingsController::class, 'updateTermsSettings'])->name('settings.updateTerms');

    //route for reportes and analystic

    Route::post('/visits/time', [VisitTimeController::class, 'updateTime'])->name('visits.time');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/user-activity-report', [ReportsController::class, 'userActivityReport'])->name('user-activity-report');

    // Cities CRUD
    Route::resource('cities', CityController::class);

    // Sub Services CRUD
    Route::resource('sub_services', SubServiceController::class);

    // Salons CRUD
    Route::resource('salons', SalonController::class);
    Route::group([
        'as'=>'salons.',  //pefor(pre) each name route
        'prefix'=>'salons', //pefor(pre) each path route
    ],function () {
        Route::get('create/step1', [SalonController::class, 'createStep1'])->name('create.step1');
        Route::post('create/step1', [SalonController::class, 'storeStep1'])->name('store.step1');
        Route::post('create/step2/{salon}', [SalonController::class, 'storeStep2'])->name('store.step2');

        // Salon Sub-Services CRUD
        Route::resource('{salon}/sub-services', SalonSubServiceController::class)->names('sub-services');
    });

    // Bookings CRUD
    Route::resource('bookings',BookingController::class);
    Route::get('bookings/{booking}/confirm', [BookingController::class, 'confirmForm'])->name('bookings.confirm-form');
    Route::post('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::get('bookings/{booking}/reject', [BookingController::class, 'rejectForm'])->name('bookings.reject-form');
    Route::post('bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
    Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('bookings/salon/{salon}', [BookingController::class, 'salonBookings'])->name('bookings.salon');
    Route::get('bookings/user/{user}', [BookingController::class, 'userBookings'])->name('bookings.user');
    Route::get('bookings/available-slots', [BookingController::class, 'getAvailableSlots'])->name('bookings.available-slots');

    // Appointments CRUD
    Route::resource('appointments', AppointmentController::class);
    Route::post('appointments/{appointment}/in-progress', [AppointmentController::class, 'markInProgress'])->name('appointments.in-progress');
    Route::post('appointments/{appointment}/completed', [AppointmentController::class, 'markCompleted'])->name('appointments.completed');
    Route::post('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('appointments/{appointment}/no-show', [AppointmentController::class, 'markNoShow'])->name('appointments.no-show');
    Route::post('appointments/{appointment}/payment-status', [AppointmentController::class, 'updatePaymentStatus'])->name('appointments.payment-status');
    Route::get('appointments/salon/{salon}', [AppointmentController::class, 'salonAppointments'])->name('appointments.salon');
    Route::get('appointments/user/{user}', [AppointmentController::class, 'userAppointments'])->name('appointments.user');
    Route::get('appointments/today', [AppointmentController::class, 'today'])->name('appointments.today');
    Route::get('appointments/upcoming', [AppointmentController::class, 'upcoming'])->name('appointments.upcoming');
    Route::get('appointments/calendar', [AppointmentController::class, 'calendar'])->name('appointments.calendar');


});

Route::prefix('dashboard/salons')->name('dashboard.salons.')->middleware(['auth', 'role:super-admin'])->group(function () {

});


// route for front website

Route::group([
    'middleware' => [],
    'as'=>'front.',  //pefor(pre) each name route
],function () {
    Route::get('/',[FrontController::class,'index']);
});


// الصفحات الرئيسية
Route::view('/home', 'frontend.index')->name('home'); // الصفحة الرئيسية
Route::view('/list', 'frontend.list')->name('list'); // صفحة تصفح الكوافيرات
Route::view('/about', 'frontend.about')->name('about'); // عن المنصة
Route::view('/faq', 'frontend.faq')->name('faq'); // صفحة الأسئلة الشائعة

// الصفحات القانونية
Route::view('/privacy-policy', 'frontend.legal.privacy')->name('privacy.policy'); // سياسة الخصوصية
Route::view('/terms-and-conditions', 'frontend.legal.terms')->name('terms.conditions'); // الشروط والأحكام

Route::view('/list/show', 'frontend.salon-show')->name('show'); // صفحة عرض الصالون

// صفحات بروفايل المستخدم
Route::view('/account', 'user.account')->name('account'); //  تعديل حساب المستخدم
Route::view('/bookings', 'user.bookings')->name('bookings'); // صفحة حجوزات المستخدم
Route::view('/favorits', 'user.favorits')->name('favorits'); // صفحة الكوافيرات المفضلة لدى المستخدم


// صفحات التسجيل / تسجيل الدخول
Route::view('/user-auth', 'auth.user-auth')->name('user-auth'); // التسجيل/تسجيل الدخول للمستخدم
Route::view('/hairdresser-auth', 'hairdresser-auth')->name('hairdresser-auth'); // التسجيل/تسجيل الدخول للكوافيرة