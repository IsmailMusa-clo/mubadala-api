<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($userId)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض المستخدمين'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($userId, User $model)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض المستخدمين'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($userId)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('انشاء المستخدمين'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($userId, User $model)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('تعديل المستخدمين'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($userId, User $model)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('حذف المستخدمين'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }
}
