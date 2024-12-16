<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = "chats";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user2_id',
        'type',
        'updated_at',
    ];

    public function user() {
        return $this->hasOne(\App\Models\User::class,"id","user_id");
    }

    public function user2() {
        return $this->hasOne(\App\Models\User::class,"id","user2_id");
    }

    public function messages() {
        return $this->hasMany(\App\Models\Chat\Message::class,"chat_id","id");
    }

    public function getModePermissions() {
        return [
            "chat" => [
                "chat.index",
                "chat.create",
                "chat.edit",
                "chat.destroy",
            ]
        ];
    }

}
