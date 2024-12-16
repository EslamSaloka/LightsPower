<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = "settings";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'group_by',
    ];

    public function getModePermissions() {
        return [
            "settings" => [
                "settings.index",
                // "settings.create",
                // "settings.destroy",
                "settings.edit",
            ]
        ];
    }

    const FORM_INPUTS = [
        'application' => [
            'title' => 'الإعددات الأساسية',
            'short_desc' => 'الإعددات الأساسية',
            'icon' => 'edit-2',
            'form' => [
                'inputs' => [
                    [
                        'label'         => 'إسم المشروع',
                        'name'          => 'system_name',
                        'type'          => 'text',
                        'placeholder'   => 'إسم المشروع',
                    ],
                    // [
                    //     // 'label'         => 'لبضريبة',
                    //     'label'         => 'قيمة الضريبه المضافه',
                    //     'name'          => 'vat',
                    //     'type'          => 'number',
                    //     'placeholder'   => 'قيمة الضريبه المضافه',
                    // ],
                    [
                        'label'         => 'البريد الإلكتروني',
                        'name'          => 'email',
                        'type'          => 'email',
                        'placeholder'   => 'البريد الإلكتروني',
                    ],
                    [
                        'label'         => 'رقم الجوال',
                        'name'          => 'phone',
                        'type'          => 'number',
                        'placeholder'   => 'رقم الجوال',
                    ],
                    [
                        'label'         => 'صوره شعار المنصة',
                        'name'          => 'logo',
                        'type'          => 'image',
                        'placeholder'   => 'صوره شعار المنصة ',
                    ],
                ],
            ],
        ],
        'social' => [
            'title' => 'سوشيال ميديا',
            'short_desc' => 'سوشيل ميديا',
            'icon' => 'twitter',
            'form' => [
                'inputs' => [
                    [
                        'label'         => 'فيسبوك',
                        'name'          => 'facebook',
                        'type'          => 'url',
                        'placeholder'   => 'فيسبوك',
                    ],
                    [
                        'label'         => 'تويتر',
                        'name'          => 'twitter',
                        'type'          => 'url',
                        'placeholder'   => 'تويتر',
                    ],
                    [
                        'label'         => 'إنستجرام',
                        'name'          => 'instagram',
                        'type'          => 'url',
                        'placeholder'   => 'إنستجرام',
                    ]
                ]
            ]
        ],
        'ppl' => [
            'title' => 'بوابات الربط الخارجي',
            'short_desc' => 'ربط بوابات',
            'icon' => 'shield',
            'form' => [
                'inputs' => [
                    [
                        'label'         => 'الفير بيز',
                        'name'          => 'firebase',
                        'type'          => 'text',
                        'placeholder'   => 'الفير بيز',
                    ]
                ]
            ]
        ],
    ];
}
