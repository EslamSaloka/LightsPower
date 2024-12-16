<?php

namespace App\Http\Controllers\API\Chat;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Chat\ChatRequests;
use App\Http\Requests\API\Chat\ChatSearchRequests;
// Models
use App\Models\Chat;
use App\Models\Chat\Message as ChatMessage;
// Support
use App\Support\API;
use App\Support\FireBase;
// Resources
use App\Http\Resources\API\Chat\ChatResources;
use App\Http\Resources\API\Chat\MessageResources;
use App\Models\User;
use App\Models\Cart\Item as CartMessage;

class ChatController extends Controller
{
    public function index() {
        if(request()->has("type")) {
            if(in_array(request("type"),["store","default"])) {
                $chats = Chat::where("user_id",\Auth::user()->id)
                    ->where("type",request("type"))
                    ->orWhere("user2_id",\Auth::user()->id)
                    ->where("type",request("type"))
                    ->orderBy("updated_at","desc")->get();
            } else {
                $chats = Chat::where("user_id",\Auth::user()->id)
                    ->orWhere("user2_id",\Auth::user()->id)
                    ->orderBy("updated_at","desc")->get();
            }
        } else {
            $chats = Chat::where("user_id",\Auth::user()->id)
                    ->orWhere("user2_id",\Auth::user()->id)
                    ->orderBy("updated_at","desc")->get();
        }


        $new_messages = Chat::select("id")->where("user_id",\Auth::user()->id)
                    ->whereHas("messages",function($q) {
                        return $q->where("seen","=",0)->where("user_id","!=",\Auth::user()->id);
                    })
                    ->orWhere("user2_id",\Auth::user()->id)
                    ->whereHas("messages",function($q) {
                        return $q->where("seen","=",0)->where("user_id","!=",\Auth::user()->id);
                    })->count();
        return (new API)->isOk(__("قائمة المحادثات"))
        ->setData(ChatResources::collection($chats))
        ->addAttribute("new_messages",$new_messages)->build();
    }

    public function show(Chat $chat) {
        // if($chat->user_id != \Auth::user()->id || $chat->user2_id != \Auth::user()->id) {
        //     return (new API)->isError(__("ليس لديك صلاحية الوصول لتلك الدردشة"))->setErrors([
        //             "object_id" => __("ليس لديك صلاحية الوصول لتلك الدردشة")
        //         ])->build();
        // }
        $messages = $chat->messages()->orderBy("id","desc")->paginate();
        $user = [];
        if($chat->user_id != \Auth::user()->id) {
            $user = [
                "id"        => (int)$chat->user_id,
                "username"  => $chat->user->username,
                "avatar"    => $chat->user->display_avatar,
                "last_action_at"    => (is_null($chat->user->last_action_at)) ? '': \Carbon\Carbon::parse($chat->user->last_action_at)->diffForHumans() ?? '',
            ];
        }

        if($chat->user2_id != \Auth::user()->id) {
            $user = [
                "id"                => (int)$chat->user2_id,
                "name"              => $chat->user2->username ?? '',
                "avatar"            => $chat->user2->display_avatar ?? '',
                "last_action_at"    => (is_null($chat->user2->last_action_at)) ? '': \Carbon\Carbon::parse($chat->user2->last_action_at)->diffForHumans() ?? '',
            ];
        }

        $chat->messages()->where("user_id","!=",\Auth::user()->id)->update([
            "seen"  => 1
        ]);


        return (new API)->isOk(__("الرسائل"))
            ->setData(MessageResources::collection($messages))
            ->addAttribute("user_receiver",$user)
            ->addAttribute("paginate",api_model_set_paginate($messages))
            ->build();
    }

    public function store(ChatRequests $request) {


        $user = \App\Models\User::find($request->user_id);
        if(is_null($user)) {
            return (new API)->isError(__("هذا المستخدم غير متوفر لدينا"))->build();
        }

        if($request->type == "post") {
            $check = \App\Models\Post::where("id",$request->message)->first();
            if(is_null($check)) {
                return (new API)->isError(__("هذا المنشور غير موجود لدينا"))->build();
            }
        }

        if($request->type == "story") {
            $check = \App\Models\Story::where("id",$request->message)->first();
            if(is_null($check)) {
                return (new API)->isError(__("هذه القصة غير موجوده"))->build();
            }
        }


        $chat = Chat::where("user_id",\Auth::user()->id)
                ->where("user2_id",$request->user_id)
                ->where("type","default")
                ->orWhere("user2_id",\Auth::user()->id)
                ->where("user_id",$request->user_id)
                ->where("type","default")
                ->first();

        if(is_null($chat)) {
            $u = User::find($request->user_id);
            if(is_null($u)) {
                return (new API)->isError(__("هذا المستخدم غير موجود"))
                ->setErrors([
                    "user_id"   => __("هذا المستخدم غير موجود")
                ])
                ->build();
            }
            $chatType = "default";

            $chat = Chat::create([
                "user_id"   => \Auth::user()->id,
                "user2_id"  => $request->user_id,
                "type"      => "default",
            ]);
        }
        if($request->type == "image") {
            $request->merge([
                "message"   => (new \App\Support\Image)->FileUpload($request->message,"chats")
            ]);
        }
        $chat->messages()->create([
            "user_id"   => \Auth::user()->id,
            "message"   => $request->message,
            "type"      => $request->type,
        ]);
        $chat->update([
            "updated_at"    => \Carbon\Carbon::now()
        ]);

        $uu = \App\Models\User::find($request->user_id);
        if(!is_null($uu)) {
            (new FireBase)->setTitle(env("APP_NAME")."-رساله جديدة")
                ->setBody($request->message ?? '')
                ->setToken($uu->tokens()->pluck("token")->toArray())
                ->build();
        }
        return (new API)->isOk(__("تم إرسال رسالتك بنجاح"))->setData([
            "chat_id"    => $chat->id
        ])->build();
    }

    public function delete(Chat $chat,ChatMessage $message) {
        if($message->user_id != \Auth::user()->id) {
            return (new API)->isError(__("ليس لديك صلاحية لحذف تلك الرساله"))->build();
        }
        if($message->chat_id != $chat->id) {
            return (new API)->isError(__("هذه الرساله غير موجوده لدا هذا الشات"))->build();
        }
        $message->delete();
        return (new API)->isOk(__("تم حذف الرساله"))->build();
    }

    public function search(ChatSearchRequests $request) {
        $user = User::where('username',"like","%".$request->name."%")->first();
        if(is_null($user)) {
            return (new API)->isError(__("هذا المستخدم غير موجود"))->setErrors([
                "username"  => __("هذا المستخدم غير موجود")
            ])->build();
        }
        $chat = Chat::where([
            "user_id"    =>  \Auth::user()->id,
            "user2_id"   =>  $user->id,
            "type"       =>  "default",
            ])->orWhere([
                "user2_id"      =>  \Auth::user()->id,
                "user_id"       =>  $user->id,
                "type"       =>  "default",
            ])->first();
        if(is_null($chat)) {
            return (new API)->isError(__("لا يوجد اي محادثات"))->build();
        }
        return (new API)->isOk(__("عرض المحادثة"))->setData(new ChatResources($chat))->build();
    }
}
