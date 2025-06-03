<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        return response()->json([
            'status' => true,
            'profile' => $user
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator($request->all(), [
            'first_name' => 'nullable|string|min:3|max:50',
            'last_name' => 'nullable|string|min:3|max:50',
            'email' => "nullable|email|unique:users,email," . auth()->id(),
            'city' => 'nullable|string',
            'area' => 'nullable|string',
            'bio' => 'nullable|string',
            'user_img' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'phone' => 'nullable|string|min:10',
            'birthday' => 'nullable|date|before:today',
        ]);
        if (!$validator->fails()) {
            $user = auth()->user();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->name = $request->input('first_name') . " " . $request->input('last_name');
            $user->city = $request->input('city');
            $user->area = $request->input('area');
            $user->bio = $request->input('bio');
            $user->phone = $request->input('phone');
            $user->birthday = $request->input('birthday');
            // $fields = ['first_name', 'last_name', 'city', 'area', 'bio', 'phone', 'birthday'];

            // foreach ($fields as $field) {
            //     if ($request->filled($field)) {
            //         $user->$field = $request->input($field);
            //     }
            // }
            // if ($request->filled('first_name') || $request->filled('last_name')) {
            //     $first = $request->filled('first_name') ? $request->input('first_name') : $user->first_name;
            //     $last = $request->filled('last_name') ? $request->input('last_name') : $user->last_name;
            //     $user->name = trim("$first $last");
            // }
            if ($request->hasFile('user_img')) {
                if (Storage::disk('public')->exists($user->user_img)) {
                    Storage::disk('public')->delete($user->user_img);
                }
                $file = $request->file('user_img');
                $path = $file->store("user_img/{$user->id}", 'public');
                $user->user_img = $path;
            }
            $isSaved = $user->save();
            return response()->json([
                'status' => $isSaved,
                'message' => $isSaved ? 'تم تحديث البروفايل بنجاح' : 'فشل تحديث البروفايل',
                'profile' => $user
            ], $isSaved ? 200 : 400);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }
}
