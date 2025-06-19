<?php

namespace App\Http\Controllers\Abilities;

use App\Http\Requests\AssignPermissionsRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * Controller for managing roles with Spatie Laravel Permission.
 */
class RoleController extends Controller
{
    protected $roleService;
    protected $permissionService;

    /**
     * RoleController constructor.
     *
     * @param RoleService $roleService
     * @param PermissionService $permissionService
     */
    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
        $this->middleware('permission:view-roles')->only(['index', 'show']);
        $this->middleware('permission:create-roles')->only(['create', 'store']);
        $this->middleware('permission:edit-roles')->only(['edit', 'update', 'assignPermissions']);
        $this->middleware('permission:delete-roles')->only(['destroy']);
    }

    /**
     * Display a listing of roles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $permissions = $this->permissionService->getAllPermissions();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     *
     * @param StoreRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $role = $this->roleService->createRole(
            $request->only('name', 'description'),
            $request->input('permissions', [])
        );

        return redirect()->route('roles.index')->with('success', 'تم إنشاء الدور بنجاح.');
    }

    /**
     * Display the specified role.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $role = $this->roleService->findRole($id)->load('permissions');
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $role = $this->roleService->findRole($id);
        $permissions = $this->permissionService->getAllPermissions();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param UpdateRoleRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $this->roleService->updateRole($id, $request->only('name', 'description'));
        $this->roleService->assignPermissions($id, $request->input('permissions', []));

        return redirect()->route('roles.index')->with('success', 'تم تحديث الدور بنجاح.');
    }

    /**
     * Remove the specified role from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->roleService->deleteRole($id);
        return redirect()->route('roles.index')->with('success', 'تم حذف الدور بنجاح.');
    }

    /**
     * Assign permissions to a role.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignPermissions(AssignPermissionsRequest $request, $id)
    {

        $this->roleService->assignPermissions($id, $request->input('permissions'));

        return redirect()->route('roles.show', $id)->with('success', 'تم تعيين الصلاحيات بنجاح.');
    }
}