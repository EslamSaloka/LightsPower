<?php

namespace App\Http\Controllers\API\Pages;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
// Models
use App\Models\Page;
// Support
use App\Support\API;
// Resources
use App\Http\Resources\API\Pages\SinglePageResources;

class PagesController extends Controller
{
    public function show($key) {
        $pages = [
            "help",
            "policy",
            "terms",
        ];
        if(!in_array($key,$pages)) {
            return (new API)->isError(__("نأسف ولكن تلك الصفحه غير موجوده"))->setErrors([
                "page"    => __("نأسف ولكن تلك الصفحه غير موجوده")
            ])->build();
        }
        $page = Page::where(["key"=>$key])->first();
        if(is_null($page)) {
            return (new API)->isError(__("نأسف ولكن تلك الصفحه غير موجوده"))->setErrors([
                "page"    => __("نأسف ولكن تلك الصفحه غير موجوده")
            ])->build();
        }
        return (new API)->isOk(__($page->name))->setData(new SinglePageResources($page))->build();
    }
}
