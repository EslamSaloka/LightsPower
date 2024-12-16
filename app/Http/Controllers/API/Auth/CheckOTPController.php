<?php

namespace App\Http\Controllers\API\Auth;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\CheckOTPRequests;
// Models
use App\Models\User\NewAccount;
use App\Models\User;
// Support
use App\Support\API;

class CheckOTPController extends Controller
{
    public function store(CheckOTPRequests $request) {
        if(is_null(request()->header("devices-token"))) {
            return (new API)->isError(__("برجاء إرسال توكن الجهاز الخاص بك"))->setErrors([
                "devices-token" => __("برجاء إرسال توكن الجهاز الخاص بك")
            ])->build();
        }
        $user = User::where(["phone"=>$request->phone])->first();
        if(!is_null($user)) {
            return (new API)->isError(__("رقم الجوال مستخدم من قبل برجاء عمل تسجيل الدخول"))->setErrors([
                "phone" => __("رقم الجوال مستخدم من قبل برجاء عمل تسجيل الدخول")
            ])->build();
        }
        $account = NewAccount::where(["phone"=>$request->phone])->first();
        if(is_null($account)) {
            return (new API)->isError(__("رقم الجوال غير موجود لدينا"))->setErrors([
                "phone" => __("رقم الجوال غير موجود لدينا")
            ])->build();
        }
        if($account->otp != $request->otp) {
            return (new API)->isError(__("كود التحقق غير صحيح"))->setErrors([
                "otp" => __("كود التحقق غير صحيح")
            ])->build();
        }
        $nUser = User::create([
            "username"              => $account->phone,
            "email"                 => $account->phone."@loopqaz.com",
            "phone"                 => $account->phone,
            "phone_verified_at"     => \Carbon\Carbon::now(),
            "password"              => \Hash::make($account->phone),
        ]);
        $nUser->assignRole(User::TYPE_CUSTOMER);
        $account->delete();
        return (new API)->isOk(__("برجاء قم بإستكمال البيانات"))->addAttribute("api_token",$nUser->setApiToken()->api_token)->build();
    }
}
