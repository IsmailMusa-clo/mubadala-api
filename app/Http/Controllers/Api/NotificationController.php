<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->get();
        return response()->json([
            'status' => true,
            'notifications' => $notifications,
        ], 200);
    }
}
