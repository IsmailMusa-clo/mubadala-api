<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        $validator = Validator($request->all(), [
            'permission_id' => 'required|integer|exists:permissions,id'
        ]);
        if (! $validator->fails()) {
            // $permission = Permission::findById($request->input('permission_id'), 'admin');
            $permission = Permission::findOrFail($request->input('permission_id'));
            $message = '';
            if ($role->hasPermissionTo($permission)) {
                $role->revokePermissionTo($permission);
                $message = 'تم حظر الصلاحية بنجاح';
            } else {
                $role->givePermissionTo($permission);
                $message = 'تم اعطاء الصلاحية بنجاح';
            }
            return response()->json([
                'message' => $message
            ], 200);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }
}
