<?php

namespace App\Policies;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OfferPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($userId)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض العروض'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($userId, Offer $offer)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض العروض'))
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
    public function update($userId, Offer $offer)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($userId, Offer $offer)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('حذف العروض'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }
}
