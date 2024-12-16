<?php

if (!function_exists('_fixDirSeparator')) {
    function _fixDirSeparator($path) {
        return str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $path);
    }
}

if(!function_exists('action_table_delete')) {
    function action_table_delete($route,$index = 0) {
        return '<form action="' . $route . '" method="post" id="form_'.$index.'">
        <input name="_method" type="hidden" value="delete">
        <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />
        <a class="btn btn-outline-danger btn-sm row_deleted" data-bs-toggle="modal" data-id="'.$index.'" data-bs-target="#staticBackdrop">
            <i class="bx bx-trash"></i>
        </a>
        </form>';
    }
}

if (!function_exists('api_model_set_paginate')) {

    function api_model_set_paginate($model)
    {
        return [
            'total'         => $model->total(),
            'lastPage'      => $model->lastPage(),
            'perPage'       => $model->perPage(),
            'currentPage'   => $model->currentPage(),
        ];
    }
}

if (!function_exists('generator_activated_code')) {
    function generator_activated_code() {
        return rand(100000,999999);
    }
}
if (!function_exists('generator_otp')) {
    function generator_otp() {
        return rand(1000,9999);
    }
}

if (!function_exists('generate_api_token')) {
    function generate_api_token() {
        $random = \Illuminate\Support\Str::random(60);
        $check = \App\Models\User\Token::where(['token' => $random,"devices_token"=>request("devices_token")])->first();
        if (!is_null($check)) {
            generate_api_token();
        }
        return $random;

    }
}

if (!function_exists('getSettings')) {
    function getSettings($var = null, $default = null,$trans = false)
    {
        $settings = \App\Models\Setting::get()->toArray();
        $data = array_column($settings, 'value', 'key');
        if(is_null($var)) {
            return $data;
        }
        return isset($data[$var]) ? $data[$var] : $default;
    }
}

if (!function_exists('displayAvatarByUser')) {
    function displayAvatarByUser(\App\Models\User $user) {
        return $user->display_avatar;
    }
}

if (!function_exists('isObjectLiked')) {
    function isObjectLiked($object_id,$object_type) {
        // Check Auth
        if(\Auth::check() == false) {
            return false;
        }

        $checkObject = null;

        if($object_type == "post") {
            $checkObject = \App\Models\Post\Like::where([
                "user_id"  => \Auth::user()->id,
                "post_id"  => $object_id,
            ])->first();
        }

        if($object_type == "story") {
            $checkObject = \App\Models\Story\Like::where([
                "user_id"  => \Auth::user()->id,
                "story_id"  => $object_id,
            ])->first();
        }

        if($object_type == "comment") {
            $checkObject = \App\Models\Post\Comment\Like::where([
                "user_id"  => \Auth::user()->id,
                "comment_id"  => $object_id,
            ])->first();
        }


        if(is_null($checkObject)) {
            return false;
        }
        return true;
    }
}


if (!function_exists('makeNewNotification')) {
    function makeNewNotification($type = "follow",\App\Models\User $user,\App\Models\User $user2,$model_id = null) {
        if($type == "follow") {
            $t = "قام ".$user2->username." بالإتصال بك";
            \App\Models\User\Notification::create([
                "user_id"    => $user->id,
                "user2_id"   => $user2->id,
                "model_type" => $type,
                "body"       => $t,
                "model_id"   => $model_id,
            ]);
            (new \App\Support\FireBase)->setSendBy("system")
                ->setMessageTo("user")
                ->setTitle("إتصال جديد")
                ->setBody($t)
                ->setModelId($model_id)
                ->setModelType($type)
                ->setToken($user2->tokens()->pluck("token")->toArray())
                ->build();
        } else if($type == "un-follow") {
            $t = "قام ".$user2->username." بإلغاء الإتصال بك";
            \App\Models\User\Notification::create([
                "user_id"    => $user->id,
                "user2_id"   => $user2->id,
                "model_type" => $type,
                "body"       => $t,
                "model_id"   => $model_id,
            ]);
            (new \App\Support\FireBase)->setSendBy("system")
            ->setMessageTo("user")
            ->setTitle("إلغاء الإتصال")
            ->setBody($t)
            ->setModelId($model_id)
            ->setModelType($type)
            ->setToken($user2->tokens()->pluck("token")->toArray())
            ->build();
        } else if($type == "post-like") {
            $t = "قام ".$user2->username."  بالإعجاب بمدونتك";
            \App\Models\User\Notification::create([
                "user_id"    => $user->id,
                "user2_id"   => $user2->id,
                "model_type" => $type,
                "body"       => $t,
                "model_id"   => $model_id,
            ]);
            (new \App\Support\FireBase)->setSendBy("system")
            ->setMessageTo("user")
            ->setTitle("إعجاب بمدونتك")
            ->setBody($t)
            ->setModelId($model_id)
            ->setModelType($type)
            ->setToken($user->tokens()->pluck("token")->toArray())
            ->build();
        } else if($type == "post-comment") {
            $t = "قام ".$user2->username."  باضافة تعليق في مدونتك";
            \App\Models\User\Notification::create([
                "user_id"    => $user->id,
                "user2_id"   => $user2->id,
                "model_type" => $type,
                "body"       => $t,
                "model_id"   => $model_id,
            ]);
            (new \App\Support\FireBase)->setSendBy("system")
            ->setMessageTo("user")
            ->setTitle("تعليق علي مدونتك")
            ->setBody($t)
            ->setModelId($model_id)
            ->setModelType($type)
            ->setToken($user->tokens()->pluck("token")->toArray())
            ->build();
        } else if($type == "post-comment-replay") {
            $t = "قام ".$user2->username."  بالرد على تعليقك ";
            \App\Models\User\Notification::create([
                "user_id"    => $user->id,
                "user2_id"   => $user2->id,
                "model_type" => $type,
                "body"       => $t,
                "model_id"   => $model_id,
            ]);
            (new \App\Support\FireBase)->setSendBy("system")
            ->setMessageTo("user")
            ->setTitle("رد على تعليق في مدونتك")
            ->setBody($t)
            ->setModelId($model_id)
            ->setModelType($type)
            ->setToken($user2->tokens()->pluck("token")->toArray())
            ->build();
        } else if($type == "post-comment-like") {
            $t = "قام ".$user2->username."  بالإعجاب بتعليقك";
            \App\Models\User\Notification::create([
                "user_id"    => $user->id,
                "user2_id"   => $user2->id,
                "model_type" => $type,
                "body"       => $t,
                "model_id"   => $model_id,
            ]);
            (new \App\Support\FireBase)->setSendBy("system")
            ->setMessageTo("user")
            ->setTitle("إعجاب بتعليقك")
            ->setBody($t)
            ->setModelId($model_id)
            ->setModelType($type)
            ->setToken($user->tokens()->pluck("token")->toArray())
            ->build();
        } else if($type == "post-comment-reply-like") {

            $t = "قام ".$user2->username."  بالإعجاب بردك";
            \App\Models\User\Notification::create([
                "user_id"    => $user->id,
                "user2_id"   => $user2->id,
                "model_type" => $type,
                "body"       => $t,
                "model_id"   => $model_id,
            ]);
            (new \App\Support\FireBase)->setSendBy("system")
            ->setMessageTo("user")
            ->setTitle("إعجاب بتعليقك")
            ->setBody($t)
            ->setModelId($model_id)
            ->setModelType($type)
            ->setToken($user2->tokens()->pluck("token")->toArray())
            ->build();

        } else if($type == "post-mention") {
            $t = "قام ".$user2->username."  بالإشارة لك في مدونته";
            \App\Models\User\Notification::create([
                "user_id"    => $user2->id,
                "user2_id"   => $user->id,
                "model_type" => $type,
                "body"       => $t,
                "model_id"   => $model_id,
            ]);
            (new \App\Support\FireBase)->setSendBy("system")
            ->setMessageTo("user")
            ->setTitle("تم الإشاره لك في منشور")
            ->setBody($t)
            ->setModelId($model_id)
            ->setModelType($type)
            ->setToken($user2->tokens()->pluck("token")->toArray())
            ->build();
        } else if($type == "comment-mention") {
            $t = "قام ".$user->username."  بالإشارة لك في تعليقه";
            \App\Models\User\Notification::create([
                "user_id"    => $user2->id,
                "user2_id"   => $user->id,
                "model_type" => $type,
                "body"       => $t,
                "model_id"   => $model_id,
            ]);

            (new \App\Support\FireBase)->setSendBy("system")
            ->setMessageTo("user")
            ->setTitle("تم الإشارة لك في تعليق")
            ->setBody($t)
            ->setModelId($model_id)
            ->setModelType($type)
            ->setToken($user2->tokens()->pluck("token")->toArray())
            ->build();
        } else if($type == "story-mention") {
            $t = "قام ".$user->username."  بالإشارة لك في قصة";
            \App\Models\User\Notification::create([
                "user_id"    => $user2->id,
                "user2_id"   => $user->id,
                "model_type" => $type,
                "body"       => $t,
                "model_id"   => $model_id,
            ]);
            (new \App\Support\FireBase)->setSendBy("system")
            ->setMessageTo("user")
            ->setTitle("تم الإشاره لك في قصة")
            ->setBody($t)
            ->setModelId($model_id)
            ->setModelType($type)
            ->setToken($user2->tokens()->pluck("token")->toArray())
            ->build();
        } else if($type == "story-like") {
            $t = "قام ".$user2->username."  بالإعجاب بقصتك";
            \App\Models\User\Notification::create([
                "user_id"    => $user->id,
                "user2_id"   => $user2->id,
                "model_type" => $type,
                "body"       => $t,
                "model_id"   => $model_id,
            ]);
            (new \App\Support\FireBase)->setSendBy("system")
            ->setMessageTo("user")
            ->setTitle("إعجاب بالقصة")
            ->setBody($t)
            ->setModelId($model_id)
            ->setModelType($type)
            ->setToken($user2->tokens()->pluck("token")->toArray())
            ->build();
        }
    }
}
