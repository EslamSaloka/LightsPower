<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected $table = "post_shares";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function user() {
        return $this->hasOne(\App\Models\User::class,"id","user_id");
    }

    public function post() {
        return $this->hasOne(\App\Models\Post::class,"id","post_id");
    }
}
