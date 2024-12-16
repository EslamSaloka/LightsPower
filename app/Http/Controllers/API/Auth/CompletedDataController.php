<?php

namespace App\Http\Controllers\API\Auth;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Auth\CompletedDataRequests;
// Models
use App\Models\User\NewAccount;
// Support
use App\Support\API;
use Carbon\Carbon;

class CompletedDataController extends Controller
{
    public function store(CompletedDataRequests $request) {
        $request->merge(["password"=>\Hash::make($request->password)]);
        $user = \Auth::user();
        $request = $request->all();
        if(in_array(1,request("specialties",[]))) {
            return (new API)->isError(__("لا يمكنك الإنضمام لهذا المدار"))->build();
        }
        if(in_array(1,request("interests",[]))) {
            return (new API)->isError(__("لا يمكنك الإنضمام لهذا المدار"))->build();
        }
        $request["suspend"]         = 0;
        $request["completed_at"]    = Carbon::now();
        $user->update($request);
        $user->specialties()->sync(request("specialties",[]));
        $user->interests()->sync(request("interests",[]));
        NewAccount::where(["phone"=>$user->phone])->delete();
        // $user->update([
        //     "last_action_at"    => \Carbon\Carbon::now()
        // ]);
        // return (new API)->isOk(__("أهلا وسهلا بك , شكرا علي الإنضمام لدينا"))->addAttribute("api_token",$user->setApiToken()->api_token)->build();
        return (new API)->isOk(__("أهلا وسهلا بك , شكرا علي الإنضمام لدينا"))->build();
    }
}
