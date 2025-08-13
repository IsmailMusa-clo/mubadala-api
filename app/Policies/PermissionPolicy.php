<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($userId)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض الصلاحيات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($userId, Permission $permission)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض الصلاحيات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($userId)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('انشاء الصلاحيات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($userId, Permission $permission)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('تعديل الصلاحيات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($userId, Permission $permission)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('حذف الصلاحيات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }
}
