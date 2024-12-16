<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Trait\User\HasApiToken;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiToken;

    const TYPE_ADMIN    = "administrator";
    const TYPE_CUSTOMER = "customer";

    protected $table = "users";
    protected $guard_name = "web";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'phone',
        'phone_verified_at',
        'password',
        'completed_at',
        'otp',
        'bio',
        'avatar',
        'cover',
        'suspend',
        'job_title',
        'last_action_at',
    ];

    public function getModePermissions() {
        return [
            "users" => [
                "users.index",
                "users.create",
                "users.edit",
                "users.destroy",
            ],
            "notifications" => [
                "notifications.index",
                "notifications.create",
                "notifications.edit",
                "notifications.destroy",
            ],
            "customers" => [
                "customers.index",
                "customers.create",
                "customers.show",
                "customers.edit",
                "customers.destroy",
            ],
            "roles" => [
                "roles.index",
                "roles.create",
                "roles.edit",
                "roles.destroy",
            ]
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeCompleted($query){
        return $query->where('suspend', 0)->whereHas('storeRequest', function($q) {
            return $q->where('status', '=', 1);
        });
    }

    public function posts() {
        return $this->hasMany(\App\Models\Post::class,"user_id","id");
    }

    public function story() {
        return $this->hasMany(\App\Models\Story::class,"user_id","id");
    }

    public function myFollower() {
        return $this->hasMany(\App\Models\User\Follow::class,"follow_id","id");
    }

    public function iFollow() {
        return $this->hasMany(\App\Models\User\Follow::class,"user_id","id");
    }

    public function notifications() {
        return $this->hasMany(\App\Models\User\Notification::class,"user_id","id");
    }

    public function getDisplayAvatarAttribute() {
        return (new \App\Support\Image)->displayImageByModel($this,"avatar");
    }

    public function getDisplayCoverAttribute() {
        return (new \App\Support\Image)->displayImageByModel($this,"cover");
    }

    public function specialties() {
        return $this->belongsToMany(\App\Models\Specialty::class, 'user_specialties_pivot', 'user_id' ,'specialty_id');
    }

    public function interests() {
        return $this->belongsToMany(\App\Models\Specialty::class, 'user_interests_pivot', 'user_id' ,'interest_id');
    }

    public static function adminDisplayPermissions() {
        return [
            "chat",
        ];
    }

    public static function adminDisplayPermissionsActions() {
        return [
            "customers.create",
        ];
    }

    public static function adminNotPermissionsActions() {
        return [
            //
        ];
    }
}
