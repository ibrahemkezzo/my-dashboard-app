<?php

namespace App\Http\Controllers\Abilities;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Services\PermissionService;
use Illuminate\Routing\Controller;

/**
 * Controller for managing permissions with Spatie Laravel Permission.
 */
class PermissionController extends Controller
{
    protected $permissionService;

    /**
     * PermissionController constructor.
     *
     * @param PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        $this->middleware('permission:view-permissions')->only(['index', 'show']);
        $this->middleware('permission:create-permissions')->only(['create', 'store']);
        $this->middleware('permission:edit-permissions')->only(['edit', 'update']);
        $this->middleware('permission:delete-permissions')->only(['destroy']);
    }

    /**
     * Display a listing of permissions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $permissions = $this->permissionService->getAllPermissions();
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new permission.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created permission in storage.
     *
     * @param StorePermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePermissionRequest $request)
    {
        $this->permissionService->createPermission($request->only('name', 'description'));
        return redirect()->route('permissions.index')->with('success', 'تم إنشاء الصلاحية بنجاح.');
    }

    /**
     * Display the specified permission.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $permission = $this->permissionService->findPermission($id);
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified permission.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $permission = $this->permissionService->findPermission($id);
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission in storage.
     *
     * @param UpdatePermissionRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        $this->permissionService->updatePermission($id, $request->only('name', 'description'));
        return redirect()->route('permissions.index')->with('success', 'تم تحديث الصلاحية بنجاح.');
    }

    /**
     * Remove the specified permission from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->permissionService->deletePermission($id);
        return redirect()->route('permissions.index')->with('success', 'تم حذف الصلاحية بنجاح.');
    }
}