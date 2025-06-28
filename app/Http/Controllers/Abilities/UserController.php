<?php

namespace App\Http\Controllers\Abilities;

use App\Http\Requests\AssignRolesRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
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

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
        $search = request()->input('search');
        $selectedRoles = request()->input('roles', []);
        $users = $this->userService->searchUsers($search, $selectedRoles);
        return view('dashboard.users.index', compact('users', 'roles', 'selectedRoles', 'search'));
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
            $request->only('name', 'email', 'password'),
            $request->input('roles', [])
        );
        return redirect()->route('dashboard.users.index')->with('success', 'تم إنشاء المستخدم بنجاح.');
    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = $this->userService->findUser($id);
        return view('dashboard.users.show', compact('user'));
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
        return view('dashboard.users.edit', compact('user', 'roles', 'userRoles'));
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
            $request->only('name', 'email', 'password'),
            $request->input('roles', [])
        );
        return redirect()->route('dashboard.users.index')->with('success', 'تم تحديث المستخدم بنجاح.');
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
        return redirect()->route('dashboard.users.index')->with('success', 'تم حذف المستخدم بنجاح.');
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
        return view('dashboard.users.roles', compact('user', 'roles', 'userRoles'));
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
        return redirect()->route('dashboard.users.show', $id)->with('success', 'تم تعيين الأدوار بنجاح.');
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
        return redirect()->route('dashboard.users.index')->with('success', "تم $status المستخدم بنجاح.");
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
