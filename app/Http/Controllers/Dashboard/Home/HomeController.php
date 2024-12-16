<?php

namespace App\Http\Controllers\Dashboard\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
// Requests
use App\Http\Requests\Dashboard\Stores\SupplierDocumentRequest;
// Models
use App\Models\Store\Document as StoreDocument;

class HomeController extends Controller
{
    public function index() {
        return view('admin.pages.home.index', [
            "statistic" => $this->adminStatistic(),
        ]);
    }

    private function adminStatistic() {
        return [
            [
                "title" => "عدد الموظفين",
                "count" => \App\Models\User::where("id","!=",1)->whereHas("roles",function($q){
                    return $q->where("name","!=",\App\Models\User::TYPE_ADMIN)->where("name","!=",\App\Models\User::TYPE_CUSTOMER);
                })->count(),
                "icon"  => 'ti-user',
            ],
            [
                "title" => "عدد مستخدمي التطبيق",
                "count" => \App\Models\User::whereHas("roles",function($q){
                    return $q->where("name",\App\Models\User::TYPE_CUSTOMER);
                })->count(),
                "icon"  => 'ti-mobile',
            ],
            [
                "title" => "عدد الرسائل الجديدة",
                "count" => \App\Models\Contact::where("seen",0)->count(),
                "icon"  => 'ti-rss',
            ],
            [
                "title" => "عدد الصفحات الإفتتاحية",
                "count" => \App\Models\Intro::count(),
                "icon"  => 'ti-blackboard',
            ],
            [
                "title" => "عدد الصفحات التعريفية",
                "count" => \App\Models\Page::count(),
                "icon"  => 'ti-book',
            ],
            [
                "title" => "عدد المنشورات",
                "count" => \App\Models\Post::where("parent",0)->count(),
                "icon"  => 'ti-pencil-alt',
            ],
            [
                "title" => "عدد المدارات",
                "count" => \App\Models\Specialty::count(),
                "icon"  => 'ti-archive',
            ],
            [
                "title" => "عدد القصص",
                "count" => \App\Models\Story::count(),
                "icon"  => 'ti-agenda',
            ],
        ];
    }

    public function logout() {
        Auth::logout();
        return redirect()->back();
    }
}
