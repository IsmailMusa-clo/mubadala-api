<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($userId)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض الادوار'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($userId, Role $role)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض الادوار'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($userId)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('انشاء الادوار'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($userId, Role $role)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('تعديل الادوار'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($userId, Role $role)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('حذف الادوار'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }
}
