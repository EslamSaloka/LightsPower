<?php

namespace App\Http\Controllers\API\Auth;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\LoginRequests;
// Models
use App\Models\User;
// Support
use App\Support\API;
// Resources
use App\Http\Resources\API\User\UserResources;

class LoginController extends Controller
{
    public function store(LoginRequests $request) {
        if(is_null(request()->header("devices-token"))) {
            return (new API)->isError(__("برجاء إرسال توكن الجهاز الخاصة بك"))->setErrors([
                "devices-token" => __("برجاء إرسال توكن الجهاز الخاصة بك")
            ])->build();
        }
        
        $authOnce = false;
        if(is_numeric($request->object)) {
            
            $authOnce = \Auth::once([
                'phone'    => $request->object,
                'password' => $request->password,
            ]);
            
        } else {
            
            $authOnce = \Auth::once([
                'username'    => $request->object,
                'password' => $request->password,
            ]);
            
        }
        if(!$authOnce) {
            return (new API)->isError(__("نأسف ولكن هذه البيانات غير متواجده لدينا"))->setErrors([
                "object"    => __("نأسف ولكن هذه البيانات غير متواجده لدينا")
            ])->build();
        }
        $user = User::find(\Auth::getUser()->id);
        if($user->suspend == 1) {
            return (new API)->isError(__("نأسف ولكن تم حظر هذا الحساب من قبل الإداره"))->setErrors([
                "object"    => __("نأسف ولكن تم حظر هذا الحساب من قبل الإداره")
            ])->build();
        }
        $user->update([
            "last_action_at"    => \Carbon\Carbon::now()
        ]);
        return (new API)->isOk(__("معلومات المستخدم"))->setData(new UserResources($user))->addAttribute("api_token",$user->setApiToken()->api_token)->build();
    }
}
