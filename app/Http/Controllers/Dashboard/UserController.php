<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validator = Validator($request->all(), [
            'first_name' => 'nullable|string|min:3|max:45',
            'last_name' => 'nullable|string|min:3|max:45',
            'phone' => 'nullable|string',
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'birthday' => 'nullable|date|before:today',
            'bio' => 'nullable|string|min:3'
        ]);

        if (!$validator->fails()) {
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->birthday = $request->input('birthday');
            $user->bio = $request->input('bio');
            $isSave = $user->save();
            return response()->json([
                'message' => $isSave  ? 'تم تعديل بيانات البروفايل بنجاح' : 'فشل تعديل بيانات البروفايل'
            ], $isSave   ? 200 : 400);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    public function updateUserImage(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validator = Validator($request->all(), [
            'user_img' => 'nullable|image'
        ]);
        if (!$validator->fails()) {

            if ($user->user_img &&  Storage::disk('public')->exists($user->user_img)) {
                Storage::disk('public')->delete($user->user_img);
            }
            $file = $request->file('user_img');
            $path = $file->store("user_img/{$user->id}", 'public');
            $user->user_img = $path;
            $isSaved = $user->save();

            return response()->json([
                'status' => $isSaved,
                'message' => $isSaved ? 'تم تحديث الصورة الشخصية بنجاح' : 'فشل تحديث الصورة الشخصية!',
                'image_url' => asset('storage/' . $path)
            ], $isSaved ? 200 : 400);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->user_img &&  Storage::disk('public')->exists($user->user_img)) {
            Storage::disk('public')->delete($user->user_img);
        }
        $isDeleted = $user->delete();
        return response()->json([
            'message' => $isDeleted ? 'تم حذف المستخدم و صفحته السخصية بنجاح' : 'فشل حذف المستخدم',
            'icon' => $isDeleted ? 'success' : 'error',
        ], $isDeleted ? 200 : 400);
    }
}
