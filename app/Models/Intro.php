<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intro extends Model
{
    use HasFactory;

    protected $table = "intros";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'active',
        'image',
    ];

    public function getModePermissions() {
        return [
            "intros" => [
                "intros.index",
                "intros.create",
                "intros.edit",
                "intros.destroy",
            ]
        ];
    }

    public function getDisplayImageAttribute() {
        return (new \App\Support\Image)->displayImageByModel($this,"image");
    }
}
