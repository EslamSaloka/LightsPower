<?php

namespace App\Http\Controllers\API\Auth;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\OTPRequests;
// Models
use App\Models\User\NewAccount;
// Support
use App\Support\API;

class OTPController extends Controller
{
    public function store(OTPRequests $request) {
        $account = NewAccount::where(["phone"=>$request->phone])->first();
        if(is_null($account)) {
            $account = NewAccount::create(["phone"=>$request->phone,"otp"=>0]);
        }
        $OTP = generator_otp();
        $account->update(["otp"=>$OTP]);
        if(env("SEND_SMS")) {
            (new \App\Support\SMS)->setPhone($account->phone)->setMessage($OTP)->build();
            return (new API)->isOk(__("تم إرسال رساله علي الجوال الخاص بك"))->build();
        } else {
            return (new API)->isOk(__("تم إرسال رساله علي الجوال الخاص بك"))->addAttribute("otp",$OTP)->build();
        }
    }
}
