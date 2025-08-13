<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($userId)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض المنتجات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($userId, Product $product)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض المنتجات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($userId)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($userId, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($userId, Product $product)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('حذف المنتجات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }
}
