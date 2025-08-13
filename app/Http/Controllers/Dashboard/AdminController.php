<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Admin::class);
        $admins = Admin::all();
        return view('admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->authorize('create', Admin::class);

        $roles = Role::where('guard_name', 'admin')->get();
        return view('admins.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Admin::class);

        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:45',
            'email' => 'required|email|unique:admins,email',
            'role_id' => 'required|integer|exists:roles,id',
        ]);
        if (!$validator->fails()) {
            $role = Role::findById($request->input('role_id'), 'admin');
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->password = Hash::make('password');
            $isSaved = $admin->save();
            if ($isSaved) {
                $admin->assignRole($role);
            }
            return response()->json([
                'message' => $isSaved ? 'تم انشاء أدمن بنجاح' : 'فشل انشاء أدمن'
            ], $isSaved ? 201 : 400);
        } else {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Admin $admin)
    {
        //
        $this->authorize('update', $admin);

        $roles = Role::where('guard_name', 'admin')->get();
        $myRole = $admin->roles->first();
        return view('admins.edit', compact('roles', 'myRole', 'admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $this->authorize('update', $admin);

        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:45',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'role_id' => 'required|integer|exists:roles,id',
        ]);
        if (!$validator->fails()) {
            $role = Role::findById($request->input('role_id'), 'admin');
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $isUpdated = $admin->update();
            if ($isUpdated) {
                $admin->syncRoles($role);
            }
            return response()->json([
                'message' => $isUpdated ? 'تم تعديل أدمن بنجاح' : 'فشل تعديل أدمن'
            ], $isUpdated ? 200 : 400);
        } else {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
        $this->authorize('delete', $admin);

        if ($admin->admin_img && Storage::disk('public')->exists($admin->admin_img)) {
            Storage::delete($admin->admin_img);
        }
        $isDelete = $admin->delete();
        return response()->json([
            'message' => $isDelete ? 'تم حذف الادمن بنجاح' : 'فشل حذف الادمن',
            'icon' => $isDelete ? 'success' : 'error',
        ], $isDelete ? 200 : 400);
    }
}
