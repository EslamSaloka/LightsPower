<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    
    protected $table = "contacts";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        // 'email',
        // 'phone',
        'message',
        'seen',
    ];
    
    public function user() {
        return $this->hasOne(\App\Models\User::class,"id","user_id");
    }

    public function showStatus()
    {
        if($this->seen == 0) {
            return '<span class="make_pad badge bg-danger">'.__("لم يتم المشاهدة").'</span>';
        } else {
            return '<span class="make_pad badge bg-success">'.__("تم المشاهده").'</span>';
        }
    }
    
    public function getModePermissions() {
        return [
            "contact-us" => [
                "contact-us.index",
                "contact-us.show",
                "contact-us.destroy",
            ]
        ];
    }
}
