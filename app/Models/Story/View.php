<?php

namespace App\Models\Story;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $table = "story_users_view";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'story_id',
    ];

    public function user() {
        return $this->hasOne(\App\Models\User::class,"id","user_id");
    }

    public function story() {
        return $this->hasOne(\App\Models\Story::class,"id","story_id");
    }
}
