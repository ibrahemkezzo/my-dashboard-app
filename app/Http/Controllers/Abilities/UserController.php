<?php

namespace App\Http\Controllers\Abilities;

use App\Http\Requests\AssignRolesRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Contracts\UserActivityInterface;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controller for managing users and their roles.
 */
class UserController extends Controller
{
    protected $userService;
    protected $userActivityService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     * @param UserActivityInterface $userActivityService
     */
    public function __construct(UserService $userService, UserActivityInterface $userActivityService)
    {
        $this->userService = $userService;
        $this->userActivityService = $userActivityService;
        $this->middleware('permission:view-users')->only(['index', 'show']);
        $this->middleware('permission:create-users')->only(['create', 'store']);
        $this->middleware('permission:edit-users')->only(['edit', 'update']);
        $this->middleware('permission:delete-users')->only(['destroy']);
        $this->middleware('permission:assign-roles')->only(['editRoles', 'assignRoles']);
        // $this->middleware('permission:export-users')->only(['export']);
    }

    /**
     * Display a listing of users with search and role filtering.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::query()->pluck('name', 'id');
        $filters = [
            'search' => request()->input('search'),
            'roles' => request()->input('roles', []),
            'status' => request()->input('status'),
            'city_id' => request()->input('city_id'),
        ];
        $users = $this->userService->getFilteredUsers($filters);
        return view('dashboard.users.index', compact('users', 'roles', 'filters'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::query()->pluck('name', 'id');
        return view('dashboard.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $this->userService->createUser(
            $request->only('name', 'email', 'phone_number','city_id','password'),
            $request->input('roles', [])
        );
        return redirect()->route('dashboard.users.index')->with('message',[
            'type' => 'success',
            'content' => __('user create successfully!')
        ]);
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Get user activity data using the service
        $activityData = $this->userActivityService->getUserActivityData($id);

        // Get user booking data
        $user = $activityData['user'];
        $bookingFilters = request()->only(['search', 'status', 'date_from', 'date_to']);
        $bookings = app(\App\Services\BookingService::class)->getByUser($user, 10, $bookingFilters);
        $bookingStatistics = app(\App\Services\BookingService::class)->getStatistics(array_merge($bookingFilters, ['user_id' => $user->id]));

        return view('dashboard.users.show', array_merge($activityData, [
            'bookings' => $bookings,
            'bookingStatistics' => $bookingStatistics
        ]));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->userService->findUser($id);
        $roles = Role::query()->pluck('name', 'id');
        $userRoles = $user->roles->pluck('name')->toArray();
        $activeTab = 'info'; // Default tab
        return view('dashboard.users.edit', compact('user', 'roles', 'userRoles', 'activeTab'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $this->userService->updateUser(
            $id,
            $request->only('name', 'email','phone_number','city_id', 'password'),
            $request->input('roles', [])
        );
        return redirect()->route('dashboard.users.index')->with('message',[
            'type' => 'success',
            'content' => __('user update successfully!')
        ]);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('dashboard.users.index')->with('message',[
            'type' => 'error',
            'content' => __('user delteted successfully!')
        ]);
    }

    /**
     * Show the form for assigning roles to a user.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function editRoles($id)
    {
        $user = $this->userService->findUser($id);
        $roles = Role::query()->pluck('name', 'id');
        $userRoles = $user->roles->pluck('name')->toArray();
        $activeTab = 'roles'; // Roles tab
        return view('dashboard.users.edit', compact('user', 'roles', 'userRoles', 'activeTab'));
    }

    /**
     * Assign roles to a user.
     *
     * @param AssignRolesRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignRoles(AssignRolesRequest $request, $id)
    {
        $this->userService->assignRoles($id, $request->input('roles'));
        return redirect()->route('dashboard.users.show', $id)->with('message',[
            'type' => 'success',
            'content' => __('Roles assigned successfully!')
        ]);
    }

    /**
     * Toggle user active status.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus($id)
    {
        $user = $this->userService->findUser($id);
        $this->userService->toggleUserStatus($id, !$user->is_active);
        $status = $user->is_active ? 'تعطيل' : 'تفعيل';
        return redirect()->route('dashboard.users.index')->with('message',[
            'type' => 'success',
            'content' => __("User $status successfully")
        ]);
    }


/**
     * Export users to Excel with applied filters.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        $search = request()->input('search');
        $roleNames = request()->input('roles', []);
        $export = new UsersExport($search, $roleNames);
        if ($export->collection()->isEmpty()) {
            return redirect()->route('dashboard.users.index')->with('error', 'لا توجد بيانات للتصدير بناءً على الفلاتر المحددة.');
        }
        return Excel::download($export, 'dashboard.users.xlsx');
    }
}
