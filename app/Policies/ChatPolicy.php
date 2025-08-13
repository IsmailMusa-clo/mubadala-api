<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChatPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($userId)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض المحادثات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($userId, Chat $chat)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('عرض المحادثات'))
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
    public function update($userId, Chat $chat)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($userId, Chat $chat)
    {
        //
        return (auth('admin')->check() && auth('admin')->user()->hasPermissionTo('حذف المحادثات'))
            ? Response::allow()
            : Response::deny('رفض الوصول، ليس لديك إذن.');
    }
}
