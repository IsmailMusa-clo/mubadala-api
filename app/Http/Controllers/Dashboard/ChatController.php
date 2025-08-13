<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function index()
    {
        $this->authorize('viewAny', Chat::class);

        $chats = Chat::with(['lastMessage', 'product', 'receiver', 'sender'])->get();
        return view('chats.index', compact('chats'));
    }

    // public function toggleStatusChat(Chat $chat)
    // {
    //     $this->authorize('toggleStatusChat', $chat);

    //     $newStatus = $chat->status === 'open' ? 'closed' : 'open';

    //     $isUpdated = $chat->update([
    //         'status' => $newStatus,
    //     ]);

    //     return response()->json([
    //         'message' => $isUpdated
    //             ? 'تم ' . ($newStatus === 'open' ? 'فتح' : 'إغلاق') . ' الدردشة بنجاح'
    //             : 'فشل تغيير حالة الدردشة',
    //         'status' => $newStatus
    //     ], $isUpdated ? 200 : 400);
    // }

    public function destroy(Chat $chat)
    {
        $this->authorize('delete', $chat);

        $isDeleted = $chat->delete();
        return response()->json([
            'status' => $isDeleted,
            'message' => $isDeleted ? 'تم حذف الدردشة بنجاح' : 'فشل حذف الدردشة',
            'icon' => $isDeleted ? 'success' : 'error',
        ], $isDeleted ? 200 : 400);
    }
}
