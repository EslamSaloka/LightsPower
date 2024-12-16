<?php

namespace App\Http\Controllers\Dashboard\Chats;

use App\Http\Controllers\Controller;
// Request
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Chat\StoreRequest;
// Models
use App\Models\Chat;
use App\Models\User;

class ChatsController extends Controller
{
    public function index(Request $request) {
        if(!in_array(User::TYPE_STORE,\Auth::user()->roles()->pluck("name")->toArray())) {
            abort(404);
        }
        if(checkCompletedSupplierData() === false) {
            abort(403);
        }
        if (in_array(\App\Models\User::TYPE_STORE,\Auth::user()->roles()->pluck("name")->toArray())) {
            if(completedSupplierDataMenu() === false) {
                abort(403);
            }
        }
        $breadcrumb = [
            'title' =>  __("المحادثات"),
            'items' =>  [
                [
                    'title' =>  __("المحادثات"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Chat::where(["user2_id"=>\Auth::user()->id,"type"=>"store"]);

        if(request()->has("user_id") && request("user_id") != '' && request("user_id") != 0) {
            $lists = $lists->where("user_id",request("user_id"));
        }
        $lists = $lists->orderBy("updated_at","desc")->paginate();


        $userIDS    = Chat::where(["user2_id"=>\Auth::user()->id,"type"=>"store"])->pluck("user_id")->toArray();
        $users      = User::select("id","username as name")->whereIn("id",$userIDS)->get();

        return view('admin.pages.chat.index',[
            'breadcrumb' => $breadcrumb,
            'lists'      => $lists,
            'users'      => $users,
        ]);
    }

    public function show(Chat $chat) {
        if(!in_array(User::TYPE_STORE,\Auth::user()->roles()->pluck("name")->toArray())) {
            abort(404);
        }
        
        $chat->messages()->where("user_id","!=",\Auth::user()->id)->update([
            "seen"  => 1
        ]);
        
        $breadcrumb = [
            'title' =>  __("بيانات الدردشه"),
            'items' =>  [
                [
                    'title' =>  __("المحادثات"),
                    'url'   =>  route('admin.chats.index'),
                ],
                [
                    'title' =>  __("بيانات الدردشه"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $user = [];
        if($chat->user_id != \Auth::user()->id) {
            $user = [
                "id"        => $chat->user->id ?? '',
                "username"  => $chat->user->username ?? '',
                "email"     => $chat->user->email ?? '',
                "phone"     => $chat->user->phone ?? '',
                "last_seen" => $chat->user->last_action_at ?? '',
            ];
        }
        if($chat->user2_id != \Auth::user()->id) {
            $user = [
                "id"        => $chat->user2->id ?? '',
                "username"  => $chat->user2->username ?? '',
                "email"     => $chat->user2->email ?? '',
                "phone"     => $chat->user2->phone ?? '',
                "last_seen" => $chat->user2->last_seen ?? '',
            ];
        }
        return view('admin.pages.chat.show',[
            'breadcrumb'    =>  $breadcrumb,
            'chat'          =>  $chat,
            'user'          =>  $user,
            'messages'      =>  $chat->messages()->get(),
        ]);
    }

    public function update(StoreRequest $request,$chat) {
        $chat = Chat::find($chat);
        $chat->messages()->create([
            "user_id"   => \Auth::user()->id,
            "message"   => $request->message,
            "type"      => "text",
        ]);
        $chat->update([
            "updated_at"    => \Carbon\Carbon::now()
        ]);
        return redirect()->route("admin.chats.show",$chat->id)->with('success',__('تم ارسال الرساله'));
    }
}
