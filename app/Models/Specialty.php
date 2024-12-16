<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    protected $table = "specialties";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'active',
    ];

    public function getDisplayImageAttribute() {
        return (new \App\Support\Image)->displayImageByModel($this,"image",false,true);
    }

    public function getModePermissions() {
        return [
            "specialties" => [
                "specialties.index",
                "specialties.create",
                "specialties.edit",
                "specialties.destroy",
            ]
        ];
    }
}
