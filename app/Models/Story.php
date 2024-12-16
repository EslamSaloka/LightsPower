<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MentionsAndTags;

class Story extends Model
{
    use HasFactory,MentionsAndTags;

    protected $table = "stories";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'specialty_id',
        'description',
        'video',
        'active',
    ];

    public function getModePermissions() {
        return [
            "stories" => [
                "stories.index",
                "stories.create",
                "stories.show",
                "stories.destroy",
            ]
        ];
    }

    public function user() {
        return $this->hasOne(\App\Models\User::class,"id","user_id");
    }

    public function likes() {
        return $this->hasMany(\App\Models\Story\Like::class,"story_id","id");
    }

    public function views() {
        return $this->hasMany(\App\Models\Story\View::class,"story_id","id");
    }

    public function specialty() {
        return $this->hasOne(\App\Models\Specialty::class,"id","specialty_id");
    }

    public function getDisplayDescriptionAttribute() {
        $mentions = $this->getMentionsUsers();
        $description = $this->description;
        if(count($mentions) > 0) {
            foreach($mentions as $m) {
                $link = "<a href='".route('admin.customers.edit',$m['user']->id)."'>".$m['user']->username."</a>";
                $description = str_replace($m["pattern"],$link,$description);
            }
        }
        // ==================================== //
        $tags = $this->getTags();
        if(count($tags) > 0) {
            foreach($tags as $t) {
                $link = "<a href='".route('admin.stories.index',["hashtag"=>$t['data']])."'>#".$t['data']."</a>";
                $description = str_replace($t["pattern"],$link,$description);
            }
        }
        // ==================================== //
        return $description;
    }

    // public function getDisplayImageAttribute() {
    //     return (new \App\Support\Image)->displayImageByModel($this,"Image");
    // }
}
