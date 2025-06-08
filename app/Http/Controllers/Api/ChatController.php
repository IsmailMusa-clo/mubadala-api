<?php

namespace App\Http\Controllers\Api;

use App\Events\ChatMessage;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Product;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSent;

class ChatController extends Controller
{
    //
    public function getOrCreateChat(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $userId = auth()->id();
        $productId = $request->product_id;
        $otherUserId = $request->receiver_id;

        $chat = Chat::where('product_id', $productId)
            ->where(function ($query) use ($userId, $otherUserId) {
                $query->where('sender_id', $userId)->where('receiver_id', $otherUserId);
            })->orWhere(function ($query) use ($userId, $otherUserId) {
                $query->where('sender_id', $otherUserId)->where('receiver_id', $userId);
            })->first();

        if (! $chat) {
            $chat = Chat::create([
                'product_id' => $productId,
                'sender_id' => $userId,
                'receiver_id' => $otherUserId,
                'status' => 'open',
            ]);
        }
        $productName = Product::findOrFail($productId)->name;
        $chat->productName = $productName;

        return response()->json([
            'status' => true,
            'chat' => $chat->load('messages.sender'),
        ], 200);
    }



    public function sendMessage(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'body' => 'required|string',
        ]);

        $userId = auth()->id();

        $chat = Chat::where('id', $request->chat_id)
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })->firstOrFail();

        $message = Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $userId,
            'body' => $request->body,
        ]);
        event(new ChatMessage($message));

        // $chat->touch();

        return response()->json([
            'status' => true,
            'message' => $message->load('sender'),
        ]);
    }

    public function inbox()
    {
        $userId = auth()->id();

        $chats = Chat::with(['lastMessage.sender', 'sender'])
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->get()
            ->map(function ($chat) use ($userId) {
                return [
                    'chat_id' => $chat->id,
                    'product_name' => $chat->product->name,
                    'status' => $chat->status,
                    'last_message' => $chat->lastMessage ? [
                        'id' => $chat->lastMessage->id,
                        'body' => $chat->lastMessage->body,
                        'created_at' => $chat->lastMessage->created_at,
                        'sender' => [
                            'id' => $chat->lastMessage->sender->id,
                            'name' => $chat->lastMessage->sender->name,
                            'user_img' => $chat->lastMessage->sender->user_img,
                        ]
                    ] : null,
                ];
            });

        if ($chats->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'لا يوجد رسائل حالياً'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'chats' => $chats
        ], 200);
    }

    public function deleteMessage(Message $message)
    {
        $isDeleted = $message->delete();
        return response()->json([
            'status' => $isDeleted,
            'message' => $isDeleted ? 'تم حذف الرسالة بنجاح' : 'فشل حذف الرسالة بنجاح'
        ], $isDeleted ? 200 : 400);
    }
}
