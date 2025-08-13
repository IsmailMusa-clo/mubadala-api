<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($userId)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض التصنيفات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($userId, Category $category)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض التصنيفات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($userId)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('انشاء التصنيفات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($userId, Category $category)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('تعديل التصنيفات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($userId, Category $category)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('حذف التصنيفات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }
}
