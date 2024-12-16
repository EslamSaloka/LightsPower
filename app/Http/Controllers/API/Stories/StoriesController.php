<?php

namespace App\Http\Controllers\API\Stories;

use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Story\StoryCreateRequests;
// Resources
use App\Http\Resources\API\Story\StoryResources;
use App\Http\Resources\API\Specialties\SpecialtiesResources;
// Support
use App\Support\API;
// Models
use App\Models\Story;
use App\Models\Specialty;
use App\Support\Image;
use Illuminate\Support\Facades\Auth;

class StoriesController extends Controller
{
    public function index() {
        $user = Auth::user();
        $ids  = $user->iFollow()->pluck("follow_id")->toArray();
        array_push($ids,$user->id);
        array_push($ids,1);
        $stories = Story::with(["user","specialty","likes","views"])->whereIn("user_id",$ids);
        if(request()->has("specialty_id") && request("specialty_id") != "" && request("specialty_id") != 0) {
            $specialty = Specialty::find(request("specialty_id"));
            if(is_null($specialty)) {
                return (new API)->isError(__("المجال التي تبحث عنه غير موجود"))->setErrors([
                    "specialty_id"  => __("المجال التي تبحث عنه غير موجود")
                ])->build();
            }
            $stories = $stories->where("specialty_id",$specialty->id);
        }
        $stories = $stories->where('active',1);
        if(request()->has('title')) {
            $titles = explode(" ",request("title"));
            $stories = $stories->where(function ($q) use ($titles) {
                foreach ($titles as $keyword) {
                   $q->orWhere('description', 'LIKE', "%$keyword%");
                }
            });
        }
        $stories = $stories->orderBy("id","desc")->paginate();
        return (new API)->isOk(__("القصص"))->setData(StoryResources::collection($stories))->addAttribute("paginate",api_model_set_paginate($stories))->build();
    }

    public function indexAll() {
        $stories = Story::with(["user","specialty","likes","views"]);
        if(request()->has("specialty_id") && request("specialty_id") != "" && request("specialty_id") != 0) {
            $specialty = Specialty::find(request("specialty_id"));
            if(is_null($specialty)) {
                return (new API)->isError(__("المجال التي تبحث عنه غير موجود"))->setErrors([
                    "specialty_id"  => __("المجال التي تبحث عنه غير موجود")
                ])->build();
            }
            $stories = $stories->where("specialty_id",$specialty->id);
        }
        $stories = $stories->where('active',1);
        if(request()->has('title')) {
            $titles = explode(" ",request("title"));
            $stories = $stories->where(function ($q) use ($titles) {
                foreach ($titles as $keyword) {
                   $q->orWhere('description', 'LIKE', "%$keyword%");
                }
            });
        }
        $stories = $stories->orderBy("id","desc")->paginate();
        return (new API)->isOk(__("القصص"))->setData(StoryResources::collection($stories))->addAttribute("paginate",api_model_set_paginate($stories))->build();
    }

    public function getSpecialties() {
        $ids = array_merge(Auth::user()->specialties()->pluck("specialty_id")->toArray(),Auth::user()->interests()->pluck("interest_id")->toArray());
        $lists = Specialty::whereIn("id",$ids)->get();
        return (new API)->isOk(__("مدارات التخصص والإهتمام"))->setData(SpecialtiesResources::collection($lists))->build();
    }

    public function store(StoryCreateRequests $request) {
        if($request->specialty_id == 1) {
            return (new API)->isError(__("لا يمكنك نشر قصتك في هذا المدار"))->setErrors([
                "specialty_id"  => __("لا يمكنك نشر قصتك في هذا المدار")
            ])->build();
        }
        $request = $request->all();
        $request["user_id"] = Auth::user()->id;
        $request["video"]   = (new Image)->FileUpload($request['video'],"stories");
        $story = Story::create($request);
        return (new API)
        ->isOk(__("تم نشر قصتك"))
        ->setData(new StoryResources($story))
        ->build();
    }

    public function show(Story $story) {
        if($story->active == 0) {
            return (new API)->isError(__("تم إيقاف تشر القصة"))->build();
        }
        $user = Auth::user();
        if($user->id != $story->user_id) {
            if(is_null($story->views()->where("user_id",$user->id)->first())) {
                $story->views()->create(["user_id"=>$user->id]);
            }
        }
        return (new API)->isOk(__("عرض بيانات القصه"))->setData(new StoryResources($story))->build();
    }

    public function likes(Story $story) {
        if($story->active == 0) {
            return (new API)->isError(__("تم إيقاف تشر القصة"))->build();
        }
        $user = Auth::user();
        // if($user->id != $story->user_id) {
            if(is_null($story->likes()->where("user_id",$user->id)->first())) {
                $like = $story->likes()->create(["user_id"=>$user->id]);

                if($story->user_id != Auth::user()->id) {
                    // ======================================= //
                    // \App\Models\User\Notification::create([
                    //     "user_id"       => $story->user_id,
                    //     "model_id"      => $like->id,
                    //     "model_type"    => "like_story",
                    //     "body"          => __("قام ".$story->user->name." بالإعجاب بالقصه الخاصه بك"),
                    // ]);
                    makeNewNotification("story-like",$story->user,Auth::user(),$like->id);
                    // ======================================= //
                }


            } else {
                $story->likes()->where("user_id",$user->id)->delete();
            }
        // }
        return (new API)->isOk(__("تم تغير حاله الإعجاب"))->build();
    }

    public function destroy(Story $story) {
        $user = Auth::user();
        if($user->id != $story->user_id) {
            return (new API)->isError(__("هذه القصه غير موجوده لديك"))->build();
        }
        $story->delete();
        return (new API)->isOk(__("تم حذف قصتك"))->build();
    }
}
