<?php

namespace App\Http\Controllers\API\Auth;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\ForgetPasswordRequests;
// Models
use App\Models\User;
// Support
use App\Support\API;

class ForgetPasswordController extends Controller
{
    public function store(ForgetPasswordRequests $request) {
        $user = User::where(["phone"=>$request->phone])->first();
        if(is_null($user)) {
            return (new API)->isError(__("رقم الجوال غير موجود لدينا"))->setErrors([
                "phone" => __("رقم الجوال غير موجود لدينا")
            ])->build();
        }
        $OTP = generator_otp();
        $user->update(["otp"=>$OTP]);
        if(env("SEND_SMS")) {
            (new \App\Support\SMS)->setPhone($user->phone)->setMessage($OTP)->build();
            return (new API)->isOk(__("تم إرسال رساله علي الجوال الخاص بك"))->build();
        } else {
            return (new API)->isOk(__("تم إرسال رساله علي الجوال الخاص بك"))->addAttribute("otp",$OTP)->build();
        }
    }
}
