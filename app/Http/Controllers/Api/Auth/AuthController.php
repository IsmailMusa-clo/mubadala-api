<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'بيانات الدخول غير صحيحة',
            ], 401);
        }

        $user = Auth::user();


        $token = $user->createToken('web-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'تم تسجيل الدخول بنجاح',
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $names = explode(' ', trim($user->name));
            $user->first_name = $names[0];
            $user->last_name = count($names) > 1 ? implode(' ', array_slice($names, 1)) : '';
            $isSaved = $user->save();
            return response()->json([
                'status' => $isSaved,
                'message' => $isSaved ? 'تم انشاء حساب جديد بنجاح' : 'فشل انشاء حساب جديد',
                'user' => $user
            ], $isSaved ? 201 : 400);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'message' => 'تم تسجيل الخروج بنجاح',
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'لم يتم العثور على مستخدم',
        ], 401);
    }
}
