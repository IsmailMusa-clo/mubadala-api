<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $this->authorize('viewAny', Permission::class);

        $permissions = Permission::all();
        return view('spatie.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // $this->authorize('create', Permission::class);
        return view('spatie.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $this->authorize('create', Permission::class);
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3'
        ]);
        if (!$validator->fails()) {
            $permission = new Permission();
            $permission->name = $request->input('name');
            $permission->guard_name = 'admin';
            $isSaved = $permission->save();
            return response()->json([
                'message' => $isSaved ? 'تم انشاء صلاحية بنجاح' : 'فشل انشاء صلاحية',
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
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
        // $this->authorize('update', $permission);

        return view('spatie.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
        // $this->authorize('update', $permission);

        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3'
        ]);
        if (!$validator->fails()) {
            $permission->name = $request->input('name');
            $isSaved = $permission->save();
            return response()->json([
                'message' => $isSaved ? 'تم انشاء صلاحية بنجاح' : 'فشل انشاء صلاحية',
            ], $isSaved ? 201 : 400);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
        // $this->authorize('delete', $permission);
        $isDeleted = $permission->delete();
        return response()->json([
            'message' => $isDeleted ? 'تم حذف الصلاحية بنجاح' : 'فشل حذف الصلاحية',
            'icon' => $isDeleted ? 'success' : 'error',
        ], $isDeleted ? 200 : 400);
    }
}
