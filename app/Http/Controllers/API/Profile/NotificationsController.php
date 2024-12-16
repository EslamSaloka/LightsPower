<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
// Resources
use App\Http\Resources\API\Notification\NotificationResources;
// Support
use App\Support\API;
// Models
use App\Models\User\Notification;

class NotificationsController extends Controller
{
    public function index() {

        if(request()->has("unseen")) {
            $notifications = \Auth::user()->notifications()->where("seen",0)->orderBy("id","desc")->paginate();
        }else{
            $notifications = \Auth::user()->notifications()->orderBy("id","desc")->paginate();
        }

        //$notifications = \Auth::user()->notifications()->orderBy("id","desc")->paginate();
        return (new API)->isOk(__("الإشعارات"))->setData(NotificationResources::collection($notifications))->addAttribute("paginate",api_model_set_paginate($notifications))->build();
    }

    public function show(Notification $notification) {
        if($notification->user_id != \Auth::user()->id) {
            return (new API)->isError(__("هذا الإشعار ليس لك"))->build();
        }
        if($notification->seen == 0) {
            $notification->update([
                "seen"  => 1
            ]);
        }
        return (new API)->isOk(__("تم المشاهده"))->addAttribute("notifications_count",\Auth::user()->notifications()->where("seen",0)->count())->build();
    }

    public function destroy(Notification $notification) {
        if($notification->user_id != \Auth::user()->id) {
            return (new API)->isError(__("هذا الإشعار ليس لك"))->build();
        }
        $notification->delete();
        $notiCount = Notification::where("user_id",\Auth::user()->id)->where("seen",0)->count();
        return (new API)->isOk(__("تم حذف الإشعار بنجاح"))->addAttribute("notifications_count",$notiCount)->build();
    }

    // ================================================= //

    public function readAll() {
        Notification::where("user_id",\Auth::user()->id)->update([
            "seen"  => 1
            ]);
        $notiCount = Notification::where("user_id",\Auth::user()->id)->where("seen",0)->count();
        return (new API)->isOk(__("تم قراءه كل الإشعارات"))->addAttribute("notifications_count",$notiCount)->build();
    }

    public function destroyAll() {
        Notification::where("user_id",\Auth::user()->id)->delete();
        $notiCount = Notification::where("user_id",\Auth::user()->id)->where("seen",0)->count();
        return (new API)->isOk(__("تم حذف الإشعارات بنجاح"))->addAttribute("notifications_count",$notiCount)->build();
    }

}
