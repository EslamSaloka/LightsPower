<?php

namespace App\Traits;

use App\Http\Resources\API\Story\UserResources;
use App\Models\User;
use App\Models\User\MAT;

trait MentionsAndTags {

    public function getMentionsIds() {
        $mm = strtolower(str_replace("App\Models\\","",get_class($this)));
        if($mm == "post\comment") {
            $mm = "comment";
        }
        return MAT::where([
            'object_id'     => $this->id,
            'object_type'   => $mm,
        ])->first()->mentions ?? [];
    }

    public function getMentionsUsers() {
        $lists = [];
        $index = 0;
        foreach($this->getMentionsIds() as $user) {
            $u = User::where("id",$user)->first();
            $lists[$index]["pattern"] = '@{'.$user.'}';
            $lists[$index]["user"] = new  UserResources($u);
            $index += 1;
        }
        return $lists;
    }

    // ======================================================= //
    public function getTags() {
        $mm = strtolower(str_replace("App\Models\\","",get_class($this)));
        if($mm == "post\comment") {
            $mm = "comment";
        }
        $tags = MAT::where([
            'object_id'     => $this->id,
            'object_type'   => $mm,
            ])->first()->tags ?? [];
            $lists = [];
        $index = 0;
        foreach($tags as $tag) {
            $lists[$index]["pattern"]   = '#{'.$tag.'}';
            $lists[$index]["data"]      = $tag;
            $index += 1;
        }
        return $lists;
    }

}
