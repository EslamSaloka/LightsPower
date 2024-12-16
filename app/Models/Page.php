<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $table = "pages";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'name',
        'content',
        'active',
    ];

    public function getModePermissions() {
        return [
            "pages" => [
                "pages.index",
                "pages.create",
                "pages.edit",
                "pages.destroy",
            ]
        ];
    }
}
