<?php

namespace App\Http\Controllers\API\Intros;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
// Models
use App\Models\Intro;
// Support
use App\Support\API;
// Resources
use App\Http\Resources\API\Intros\IntrosResources;

class IntrosController extends Controller
{
    public function index() {
        return (new API)->isOk(__("عرض الصفحات الإفتتاحية"))->setData(IntrosResources::collection(Intro::all()))->build();
    }
}
