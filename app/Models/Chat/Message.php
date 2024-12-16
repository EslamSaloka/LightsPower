<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = "chat_messages";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
        'seen',
        'type', // text || image || post || story
    ];

    public function user() {
        return $this->hasOne(\App\Models\User::class,"id","user_id");
    }

    public function chat() {
        return $this->hasOne(\App\Models\Chat::class,"id","chat_id");
    }
    
    public function product() {
        return $this->hasOne(\App\Models\Product::class,"id","message");
    }
    
    public function store() {
        return $this->hasOne(\App\Models\User::class,"id","message");
    }
}
