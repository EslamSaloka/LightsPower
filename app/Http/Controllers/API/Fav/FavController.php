<?php

namespace App\Http\Controllers\API\Fav;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Fav\FavRequests;
// Models
use App\Models\User\Fav;
use App\Models\User;
use App\Models\Product;
// Support
use App\Support\API;
// Resources
use App\Http\Resources\API\Product\ProductResources;
use App\Http\Resources\API\Store\StoreResources;

class FavController extends Controller
{
    public function index() {
        if(!request()->has("object_type")) {
            return (new API)->isError(__("برجاء إدخال النوع متجر او منتج"))->setErrors([
                "object_type"   => __("برجاء إدخال النوع متجر او منتج")
            ])->build();
        }
        if(request("object_type","product") == "product") {
            $ids  = Fav::where(["user_id"=>\Auth::user()->id,"object_type"=>"product"])->pluck("object_id")->toArray();
            $data = ProductResources::collection(Product::whereIn("id",$ids)->completed()->get());
        } else {
            $ids  = Fav::where(["user_id"=>\Auth::user()->id,"object_type"=>"store"])->pluck("object_id")->toArray();
            $data = StoreResources::collection(User::whereIn("id",$ids)->get());
        }
        return (new API)->isOk(__("المفضله"))->setData($data)->build();
    }

    public function storeOrDestroy(FavRequests $request) {
        if($request->object_type == "product") {
            $object = Product::where("id", $request->object_id)->where("type","product")->first();
            if(is_null($object)) {
                return (new API)->isError(__("هذا العنصر غير موجود لدينا"))->setErrors([
                    "object_id" => __("هذا العنصر غير موجود لدينا")
                ])->build();
            }
            // if($object->where('store_suspend', 0)->where('plan_suspend', 0)->first()) {
            if($object->store_suspend == 1 || $object->plan_suspend ==1 ) {
                return (new API)->isError(__("هذا المنتج تم حجبه"))->setErrors([
                    "object_id" => __("هذا المنتج تم حجبه")
                ])->build();
            }
        } else {
            $object = User::where("id",$request->object_id)->whereHas("roles",function($q){
                return $q->where("name",User::TYPE_STORE);
            })->first();
            if(is_null($object)) {
                return (new API)->isError(__("هذا العنصر غير موجود لدينا"))->setErrors([
                    "object_id" => __("هذا العنصر غير موجود لدينا")
                ])->build();
            }
            if($object->suspend == 1) {
                return (new API)->isError(__("هذا المتجر تم حجبه"))->setErrors([
                    "object_id" => __("هذا المتجر تم حجبه")
                ])->build();
            }
            if(is_null($object->storePlanHistories()->where("active",1)->where("end",0)->first())) {
                return (new API)->isError(__("هذا المتجر تم حجبه"))->setErrors([
                    "object_id" => __("هذا المتجر تم حجبه")
                ])->build();
            }
        }
        $fav = Fav::where([
            "user_id"       => \Auth::user()->id,
            "object_id"     => $object->id,
            "object_type"   => $request->object_type,
        ])->first();
        if(is_null($fav)) {
            Fav::create([
                "user_id"       => \Auth::user()->id,
                "object_id"     => $object->id,
                "object_type"   => $request->object_type,
            ]);
            return (new API)->isOk(__("تم الإضافه إلي المفضلة"))->build();
        }
        $fav->delete();
        return (new API)->isOk(__("تم الحذف من المفضلة"))->build();
    }
}
