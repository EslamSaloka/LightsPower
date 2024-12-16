<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Profile\ProfileRequests;
use App\Http\Requests\API\Profile\PasswordUpdateRequests;
use App\Http\Requests\API\Profile\AvatarUpdateRequests;
use App\Http\Requests\API\Profile\CoverUpdateRequests;
use App\Http\Requests\API\Profile\SpecialtiesUpdateRequests;
use App\Http\Requests\API\Profile\InterestsUpdateRequests;
// Resources
use App\Http\Resources\API\User\UserResources;
use App\Http\Resources\API\User\UserAccountResources;
use App\Http\Resources\API\Post\PostResources;
use App\Http\Resources\API\Specialties\SpecialtiesResources;
use App\Http\Resources\API\Story\StoryResources;
use App\Models\Story;
use App\Models\User;
// Support
use App\Support\API;
use App\Support\Image;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        return (new API)->isOk(__("معلومات المستخدم"))->setData(new UserResources(Auth::user()))->build();
    }

    public function update(ProfileRequests $request) {
        $user = Auth::user();
        $user->update($request->only(["username","bio","email","phone","job_title"]));
        return (new API)->isOk(__("تم تغير البيانات بنجاح"))->setData(new UserResources($user))->build();
    }

    public function updatePassword(PasswordUpdateRequests $request) {
        $user = Auth::user();
        if(!\Hash::check($request->old_password, $user->password)) {
            return (new API)->isOk(__("كلمة المرور القديمة غير صحيحة"))->setErrors([
                "old_password"  => __("كلمة المرور القديمة غير صحيحة")
            ])->build();
        }
        $user->update([
            "password"  => \Hash::make($request->password)
        ]);
        return (new API)->isOk(__("تم تغير كلمه المرور"))->setData(new UserResources($user))->build();
    }

    public function updateCover(CoverUpdateRequests $request) {
        $user = Auth::user();
        $user->update([
            "cover"  => (new Image)->FileUpload($request->cover,"users")
        ]);
        return (new API)->isOk(__("تم تغير الصوره الشخصية"))->setData(new UserResources($user))->build();
    }

    public function updateAvatar(AvatarUpdateRequests $request) {
        $user = Auth::user();
        $user->update([
            "avatar"  => (new Image)->FileUpload($request->avatar,"users")
        ]);
        return (new API)->isOk(__("تم تغير الصوره الشخصية"))->setData(new UserResources($user))->build();
    }

    public function specialties() {
        return (new API)->isOk(__("مجالات التخصص الخاصه بك"))->setData(SpecialtiesResources::collection(Auth::user()->specialties))->build();
    }

    public function specialtiesUpdate(SpecialtiesUpdateRequests $request) {
        if(in_array(1,request("specialties",[]))) {
            return (new API)->isError(__("لا يمكنك الإنضمام لهذا المدار"))->build();
        }
        if(count(request("specialties",[])) > 3) {
            return (new API)->isError(__("الحد الأقصي لمجالات التخصص ثلاث"))->build();
        }
        Auth::user()->specialties()->sync(request("specialties",[]));
        return (new API)->isOk(__("مجالات التخصص الخاصه بك"))->setData(SpecialtiesResources::collection(Auth::user()->specialties))->build();
    }

    public function interests() {
        return (new API)->isOk(__("مجالات الإهتمام الخاصه بك"))->setData(SpecialtiesResources::collection(Auth::user()->interests))->build();
    }

    public function interestsUpdate(InterestsUpdateRequests $request) {
        if(in_array(1,request("interests",[]))) {
            return (new API)->isError(__("لا يمكنك الإنضمام لهذا المدار"))->build();
        }
        if(count(request("interests",[])) > 3) {
            return (new API)->isError(__("الحد الأقصي لمجالات الإهتمام ثلاث"))->build();
        }
        Auth::user()->interests()->sync(request("interests",[]));
        return (new API)->isOk(__("مجالات الإهتمام الخاصه بك"))->setData(SpecialtiesResources::collection(Auth::user()->interests))->build();
    }

    public function getMyPosts() {
        $posts = Auth::user()->posts()->where("parent",0)->orderBy("id","desc")->paginate();
        return (new API)->isOk(__("المنشورات"))->setData(PostResources::collection($posts))->addAttribute("paginate",api_model_set_paginate($posts))->build();
    }

    public function getMyStories() {
        $stories = Story::with(["user","specialty","likes","views"]);
        $stories = $stories->where('active',1)->where("user_id",Auth::user()->id);
        $stories = $stories->orderBy("id","desc")->paginate();
        return (new API)->isOk(__("القصص"))->setData(StoryResources::collection($stories))->addAttribute("paginate",api_model_set_paginate($stories))->build();
    }

    public function accountDestroy() {
        Auth::user()->delete();
        return (new API)->isOk(__("تم مسح الحساب"))->build();
    }

    public function logout() {
        Auth::user()->deleteToken();
        return (new API)->isOk(__("تم تسجيل الخروج بنجاح"))->build();
    }
    // ============================== //

    public function followers() {
        $user = Auth::user();
        $ids = $user->myFollower()->pluck("user_id")->toArray();
        $users = User::whereIn("id",$ids)->orderBy("id","desc")->paginate();
        return (new API)->isOk(__("قائمة المتابعين"))
        ->setData(UserAccountResources::collection($users) )->addAttribute("paginate",api_model_set_paginate($users))->build();
    }

    public function following() {
        $user = Auth::user();
        $ids = $user->iFollow()->pluck("follow_id")->toArray();
        $users = User::whereIn("id",$ids)->orderBy("id","desc")->paginate();
        return (new API)->isOk(__("قائمة متابعيني"))
        ->setData(UserAccountResources::collection($users) )->addAttribute("paginate",api_model_set_paginate($users))->build();
    }

    public function followersAndFollowing() {
        $user = Auth::user();
        $ids1 = $user->iFollow()->pluck("follow_id")->toArray();
        $ids2 = $user->myFollower()->pluck("user_id")->toArray();
        $arr  = array_merge($ids1,$ids2);
        if(request()->has("all")) {
            $users = User::whereIn("id",$arr)->orderBy("id","desc")->get();
            return (new API)->isOk(__("قائمه المستخدمين"))->setData(UserAccountResources::collection($users))->build();
        } else {
            $users = User::whereIn("id",$arr)->orderBy("id","desc")->paginate();
            return (new API)->isOk(__("قائمه المستخدمين"))
            ->setData(UserAccountResources::collection($users))->addAttribute("paginate",api_model_set_paginate($users))->build();
        }
    }

    public function notificationsCount() {
         return (new API)->isOk(__("عدد الإشعارات"))
        ->setData([
            'notifications'         => Auth::user()->notifications()->where("seen",0)->count(),
        ])->build();
    }
}
