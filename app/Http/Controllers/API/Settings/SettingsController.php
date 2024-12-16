<?php

namespace App\Http\Controllers\API\Settings;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
// Support
use App\Support\API;

class SettingsController extends Controller
{
    public function index() {
        $settings = [
            "phone"         => getSettings("phone",null),
            "email"         => getSettings("email",null),
            "social"        => [
                "facebook"  => getSettings("facebook",null),
                "twitter"  => getSettings("twitter",null),
                "instagram"  => getSettings("instagram",null),
            ]
        ];
        return (new API)->isOk(__("عرض إعدادات التطبيق"))->setData($settings)->build();
    }
}
