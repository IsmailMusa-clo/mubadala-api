<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    //
    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string|min:8|max:20',
            'remeber_me' => 'nullable|boolean',
        ], [
            'email.exists' => 'عذرًا، هذا البريد الإلكتروني غير مسجل لدينا.',
        ]);
        if (! $validator->fails()) {
            $credintials = [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ];
            if (Auth::guard('admin')->attempt($credintials, $request->input('remember_me'))) {
                return response()->json([
                    'message' => 'تم تسجيل الدخول'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'خطا في بيانات الدخول'
                ], 400);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        // $guard = auth('web')->check() ? "web" : "admin";
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('login-view', 'admin');
    }

    public function profile()
    {
        return view('auth.profile');
    }


    public function profileEdit()
    {
        return view('auth.edit-profile');
    }


    public function profileUpdate(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore(auth('admin')->id()),
            ],
        ]);
        if (! $validator->fails()) {
            $admin = auth('admin')->user();
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $isSaved = $admin->save();
            return response()->json([
                'message' => $isSaved ? 'تم تحديث البروفايل بنجاح' : 'فشل تحديث البروفايل'
            ], $isSaved ? 200 : 400);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    public function updatePassword(Request $request)
    {
        $guard = auth('web')->check() ? 'web' : 'admin';
        $validator = Validator($request->all(), [
            'password' => 'required|string|current_password:' . $guard,
            'new_password' => 'required|string|min:8|max:30|confirmed',
            'new_password_confirmation' => 'required|string|min:8|max:30',
        ]);
        if (! $validator->fails()) {
            $admin = auth($guard)->user();
            $admin->password = Hash::make($request->input('new_password'));
            $isUpdate = $admin->save();
            return response()->json([
                'message' => $isUpdate ? 'تم تعديل كلمة المرور' : 'فشل تعديل كلمة المرور'
            ], $isUpdate ? 200 : 400);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    public function updateAvatar(Request $request)
    {
        $validator = Validator($request->all(), [
            'admin_img' => 'nullable|image'
        ]);
        if (!$validator->fails()) {
            $admin = Auth::guard('admin')->user();
            if ($admin->admin_img &&  Storage::disk('public')->exists($admin->admin_img)) {
                Storage::disk('public')->delete($admin->admin_img);
            }
            $file = $request->file('admin_img');
            $path = $file->store("admin_img/{$admin->id}", 'public');
            $admin->admin_img = $path;
            $isSaved = $admin->save();
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
}
