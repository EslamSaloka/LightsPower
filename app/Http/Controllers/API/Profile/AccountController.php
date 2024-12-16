<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
// Resources
use App\Http\Resources\API\User\UserResources;
use App\Http\Resources\API\User\UserAccountResources;
use App\Http\Resources\API\Post\PostResources;
use App\Http\Resources\API\Story\StoryResources;
use App\Models\Story;
// Support
use App\Support\API;
use App\Support\Image;
// Models
use App\Models\User;
use App\Models\User\Follow;

class AccountController extends Controller
{
    public function index(User $profile) {
        $user = \Auth::user();
        if($profile->roles()->first()->name != User::TYPE_CUSTOMER) {
            return (new API)->isError(__("هذا الحساب ليس بعميل"))->build();
        }
        if($profile->id == $user->id) {
            return (new API)->isError(__("لا يمكنك عرض حسابك من هنا"))->build();
        }
        $ids = $user->iFollow()->pluck("follow_id")->toArray();
        $isIFollow = in_array($profile->id,$ids) ? true : false;
        return (new API)->isOk(__("معلومات المستخدم"))
        ->setData(new UserAccountResources($profile))->addAttribute("follow_him",$isIFollow)->build();
    }

    public function posts(User $profile) {
        $user = \Auth::user();
        if($profile->roles()->first()->name != User::TYPE_CUSTOMER) {
            return (new API)->isError(__("هذا الحساب ليس بعميل"))->build();
        }
        if($profile->id == $user->id) {
            return (new API)->isError(__("لا يمكنك عرض حسابك من هنا"))->build();
        }
        $posts = $profile->posts()->where("parent",0)->orderBy("id","desc")->paginate();
        return (new API)->isOk(__("المنشورات"))->setData(PostResources::collection($posts))->addAttribute("paginate",api_model_set_paginate($posts))->build();
    }

    public function stories(User $profile) {
        if($profile->roles()->first()->name != User::TYPE_CUSTOMER) {
            return (new API)->isError(__("هذا الحساب ليس بعميل"))->build();
        }
        $stories = Story::with(["user","specialty","likes","views"]);
        $stories = $stories->where('active',1)->where("user_id",$profile->id);
        $stories = $stories->orderBy("id","desc")->paginate();
        return (new API)->isOk(__("القصص"))->setData(StoryResources::collection($stories))->addAttribute("paginate",api_model_set_paginate($stories))->build();
    }

    public function follow(User $profile) {
        $user = \Auth::user();
        if($profile->roles()->first()->name != User::TYPE_CUSTOMER) {
            return (new API)->isError(__("هذا الحساب ليس بعميل"))->build();
        }
        if($profile->id == $user->id) {
            return (new API)->isError(__("لا يمكنك متابعه نفسك"))->build();
        }
        $ids = $user->iFollow()->pluck("follow_id")->toArray();
        if(in_array($profile->id,$ids)) {
            $user->iFollow()->where([
                "follow_id" => $profile->id
            ])->delete();
            makeNewNotification("un-follow",$profile,\Auth::user(),null);
            return (new API)->isOk(__("تم إلغاء المتابعة"))->build();
        } else {
            $user->iFollow()->create([
                "follow_id" => $profile->id
            ]);
            makeNewNotification("follow",$profile,\Auth::user(),null);
            // ======================================= //

            return (new API)->isOk(__("تم متابعة هذا المستخدم"))->build();
        }
    }
}
