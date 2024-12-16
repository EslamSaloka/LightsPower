<?php

namespace App\Http\Controllers\API\Auth;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\NewPasswordRequests;
// Models
use App\Models\User;
// Support
use App\Support\API;

class NewPasswordController extends Controller
{
    public function store(NewPasswordRequests $request) {
        $user = User::where(["phone"=>$request->phone])->first();
        if(is_null($user)) {
            return (new API)->isError(__("رقم الجوال غير موجود لدينا"))->setErrors([
                "phone" => __("رقم الجوال غير موجود لدينا")
            ])->build();
        }
        if($user->otp != $request->otp) {
            return (new API)->isError(__("كود التحقق غير صحيح"))->setErrors([
                "otp" => __("كود التحقق غير صحيح")
            ])->build();
        }
        $user->update([
            "password"  => \Hash::make($request->password),
            "otp"       => generator_otp()
        ]);
        return (new API)->isOk(__("تم تغير كلمة المرور بنجاح"))->build();
    }
}
