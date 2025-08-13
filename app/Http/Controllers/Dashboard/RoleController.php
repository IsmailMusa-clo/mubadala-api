<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Role::class);
        $roles = Role::withCount('permissions')->get();
        return view('spatie.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->authorize('create', Role::class);
        return view('spatie.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $this->authorize('create', Role::class);

        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3'
        ]);
        if (! $validator->fails()) {
            $role = new Role();
            $role->name = $request->input('name');
            $role->guard_name = 'admin';
            $isSaved = $role->save();
            return response()->json([
                'message' => $isSaved ? 'تم انشاء دور بنجاح' : 'فشل انشاء دور'
            ], $isSaved ? 201 : 400);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
        // $this->authorize('view', $role);

        $permissions = Permission::where('guard_name', $role->guard_name)->get();
        $rolePermissions = $role->permissions;
        foreach ($permissions as $permission) {
            $permission->setAttribute('assigned', false);
            foreach ($rolePermissions as $rolePermission) {
                if ($rolePermission->id == $permission->id) {
                    $permission->setAttribute('assigned', true);
                }
            }
        }
        return view('spatie.roles.role-permissions', compact('permissions', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
        // $this->authorize('update', $role);

        return view('spatie.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        // $this->authorize('update', $role);

        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3'
        ]);
        if (! $validator->fails()) {
            $role->name = $request->input('name');
            $isUpdated = $role->update();
            return response()->json([
                'message' => $isUpdated ? 'تم تعديل دور بنجاح' : 'فشل تعديل دور'
            ], $isUpdated ? 201 : 400);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
        $this->authorize('delete', $role);

        $isDeleted = $role->delete();
        return response()->json([
            'message' => $isDeleted ? 'تم حذف الدور بنجاح' : 'فشل حذف الدور',
            'icon' => $isDeleted ? 'success' : 'error',
        ], $isDeleted ? 200 : 400);
    }
}
