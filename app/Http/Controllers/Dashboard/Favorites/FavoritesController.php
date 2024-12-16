<?php

namespace App\Http\Controllers\Dashboard\Favorites;

use App\Http\Controllers\Controller;
use App\Models\Product;
// Request
use Illuminate\Http\Request;
// Models
use App\Models\User\Fav;
use App\Models\User;

class FavoritesController extends Controller
{
    public function index(Request $request) {
        if(!in_array(User::TYPE_STORE,\Auth::user()->roles()->pluck("name")->toArray())) {
            abort(404);
        }
        if (!in_array(32,storePlanPermissions())) {
            abort(401);
        }
        $breadcrumb = [
            'title' =>  __("قائمة المفضلة للمتجر والمنتجات"),
            'items' =>  [
                [
                    'title' =>  __("قائمة المفضلة للمتجر والمنتجات"),
                    'url'   =>  route("admin.favorites.index"),
                ]
            ],
        ];
        $ids1 = Fav::where(['object_type'=> "product"])->whereHas("product",function($q) {
            return $q->where("store_id",\Auth::user()->id);
        })->pluck("user_id")->toArray();
        $ids2 = Fav::where(['object_id'=> \Auth::user()->id,'object_type'=> "store"])->pluck("user_id")->toArray();
        return view('admin.pages.favorites.index',[
            'breadcrumb' => $breadcrumb,
            'lists'      => [
                "products"  => User::whereIn("id",$ids1)->get(),
                "stores"    => User::whereIn("id",$ids2)->get(),
            ],
        ]);
    }

    public function show(User $favorite) {
        if(!in_array(User::TYPE_STORE,\Auth::user()->roles()->pluck("name")->toArray())) {
            abort(404);
        }
        if (!in_array(32,storePlanPermissions())) {
            abort(401);
        }
        $breadcrumb = [
            'title' =>  __("قائمة المفضلة للمنتجات"),
            'items' =>  [
                [
                    'title' =>  __("قائمة المفضلة للمنتجات"),
                    'url'   =>  route("admin.favorites.index"),
                ],
                [
                    'title' =>  __("المنتجات"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $ids = Fav::where(['user_id'=> $favorite->id,'object_type'=> "product"])->pluck("object_id")->toArray();
        $lists = Product::whereIn("id",$ids)->where("store_id",\Auth::user()->id)->get();
        return view('admin.pages.favorites.show',[
            'breadcrumb' => $breadcrumb,
            'lists'      => $lists,
        ]);
    }
}
