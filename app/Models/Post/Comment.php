<?php

namespace App\Models\Post;

use App\Traits\MentionsAndTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory,MentionsAndTags;

    protected $table = "post_comments";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'comment_id',
        'comment',
    ];

    public function comments() {
        return $this->hasMany(\App\Models\Post\Comment::class,"comment_id","id");
    }

    public function likes() {
        return $this->hasMany(\App\Models\Post\Comment\Like::class,"comment_id","id");
    }

    public function user() {
        return $this->hasOne(\App\Models\User::class,"id","user_id");
    }

    public function post() {
        return $this->hasOne(\App\Models\Post::class,"id","post_id");
    }


    public function getDisplayCommentAttribute() {
        $mentions = $this->getMentionsUsers();
        $comment = $this->comment;
        if(count($mentions) > 0) {
            foreach($mentions as $m) {
                $link = "<a href='".route('admin.customers.edit',$m['user']->id)."'>".$m['user']->username."</a>";
                $comment = str_replace($m["pattern"],$link,$comment);
            }
        }
        // ==================================== //
        $tags = $this->getTags();
        if(count($tags) > 0) {
            foreach($tags as $t) {
                $link = "<a href='".route('admin.posts.index',["hashtag"=>$t['data']])."'>#".$t['data']."</a>";
                $comment = str_replace($t["pattern"],$link,$comment);
            }
        }
        // ==================================== //
        return $comment;
    }

}
