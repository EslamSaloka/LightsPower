<?php

namespace App\Http\Controllers\Dashboard\Notifications;

use App\Http\Controllers\Controller;
// Request
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Notifications\CreateRequest;
// Support
use App\Support\FireBase;
// Models
use App\Models\User;

class NotificationsController extends Controller
{
    protected $fileName = "notifications";
    protected $controllerName = "الإشعارات";
    protected $routeName = "notifications";

    public function getCustomers() {
        return User::select("id","username")->whereHas("roles",function($q){
            return $q->where("name",User::TYPE_CUSTOMER);
        })->latest()->get();
    }

    public function index() {
        $breadcrumb = [
            'title' =>  __("نشر إشعار جديد").'( push notification )',
            'items' =>  [
                [
                    'title' =>  __("نشر إشعار جديد"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ]
            ],
        ];
        $users = $this->getCustomers();
        return view("admin.pages.$this->fileName.index",get_defined_vars());
    }

    public function store(CreateRequest $request) {
        $tokens = [];
        if(in_array(0,request("users",[])) || count(request("users",[])) == 0) {
            $users  = User::all();
        } else {
            $users  = User::whereIn("id",request("users",[]))->get();
        }
        foreach($users as $user) {
            foreach($user->tokens()->pluck("token")->toArray() as $v) {
                array_push($tokens,$v);
            }
            \App\Models\User\Notification::create([
                "user_id"    => $user->id,
                "user2_id"   => 1,
                "model_type" => "admin",
                "body"       => $request->content ?? '',
                "model_id"   => 0,
            ]);
        }

        (new \App\Support\FireBase)->setSendBy("admin")
            ->setMessageTo("user")
            ->setTitle(env("APP_NAME"))
            ->setBody($request->content ?? '')
            ->setToken($tokens)
            ->build();
        return redirect()->route("admin.$this->routeName.index")->with('success',__('تم إرسال الإشعار بنجاح'));
    }
}
