<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class VerifyEmailController extends Controller
{
    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!$user->hasVerifiedEmail()) {
           $user->markEmailAsVerified();
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
    }

    public function resend(Request $request)
    {
        $user=User::findOrFail($request->id);

        if ($user->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 402);
        }    
        $user->sendEmailVerificationNotification();
        return response()->json(["message" => "Email verification link sent on your email id"], 200);
    }
}