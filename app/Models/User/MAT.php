<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MAT extends Model
{
    use HasFactory;

    protected $table = "mentions_tags";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'object_id',
        'object_type',
        'mentions',
        'tags',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'mentions'  => 'array',
        'tags'      => 'array',
    ];

}
