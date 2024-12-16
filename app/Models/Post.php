<?php

namespace App\Models;

use App\Traits\MentionsAndTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory,MentionsAndTags;

    protected $table = "posts";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'description',
        'parent',
        // ============================= //
        'post_type',    // post || product || store
        'post_type_id',
    ];

    public function getModePermissions() {
        return [
            "posts" => [
                "posts.index",
                "posts.create",
                "posts.show",
                "posts.destroy",
            ]
        ];
    }

    public function user() {
        return $this->hasOne(\App\Models\User::class,"id","user_id");
    }

    public function images() {
        return $this->hasMany(\App\Models\Post\Image::class,"post_id","id");
    }

    public function getDisplayMainImageAttribute() {
        return $this->images()->first()->display_image ?? (new \App\Support\Image)->displayImage(null);
    }

    public function getDisplayDescriptionAttribute() {
        $mentions = $this->getMentionsUsers();
        $description = $this->description;
        if(count($mentions) > 0) {
            foreach($mentions as $m) {
                $link = "<a href='".route('admin.customers.edit',$m['user']->id)."'>@".$m['user']->username."</a>";
                $description = str_replace($m["pattern"],$link,$description);
            }
        }
        // ==================================== //
        $tags = $this->getTags();
        if(count($tags) > 0) {
            foreach($tags as $t) {
                $link = "<a href='".route('admin.posts.index',["hashtag"=>$t['data']])."'>#".$t['data']."</a>";
                $description = str_replace($t["pattern"],$link,$description);
            }
        }
        // ==================================== //
        return $description;
    }

    public function getDisplayPostTypeAttribute() {
        return new \App\Http\Resources\API\Post\PostResources(\App\Models\Post::find($this->post_type_id));
    }

    public function likes() {
        return $this->hasMany(\App\Models\Post\Like::class,"post_id","id");
    }

    public function comments() {
        return $this->hasMany(\App\Models\Post\Comment::class,"post_id","id");
    }

    public function shares() {
        return $this->hasMany(\App\Models\Post\Share::class,"post_id","id");
    }

    public function threads() {
        return $this->hasMany(\App\Models\Post::class,"parent","id");
    }
}
