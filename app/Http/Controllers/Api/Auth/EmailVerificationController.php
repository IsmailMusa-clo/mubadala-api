<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    //

    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'فشل إرسال رابط التحقق.'], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'البريد الاكتروني مفعل من قبل.']);
        }

        $user->markEmailAsVerified();
        $user->status = 'active';
        $user->save();
        // event(new Verified($user));

        return response()->json(['message' => 'تم تفعيل البريد الإلكتروني بنجاح.']);
    }


    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'البريد الاكتروني مفعل من قبل.'], 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'تم إرسال رابط التحقق إلى بريدك الإلكتروني!']);
    }
}
