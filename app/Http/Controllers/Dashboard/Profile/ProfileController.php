<?php

namespace App\Http\Controllers\Dashboard\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Profile\UpdatePasswordRequest;
use App\Http\Requests\Dashboard\Profile\UpdateProfileRequest;
use App\Http\Requests\Dashboard\Profile\UpdateStoreDataRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("بيانات الحساب الشخصي"),
            'items' =>  [
                [
                    'title' =>  __("بيانات الحساب الشخصي"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $user = Auth::user();

        return view('admin.pages.profile.index', compact('breadcrumb', 'user'));
    }

    public function store(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        if($request->hasFile('avatar')){
            $data['avatar'] = (new \App\Support\Image)->FileUpload($request->avatar, 'users');
        }
        Auth::user()->update($data);
        return Redirect::route('admin.profile.index')->with('success', __("تم تحديث البيانات",['item' => __('Profile')]) );
    }

    public function change_password()
    {
        $breadcrumb = [
            'title' =>  __("تغيير كلمه المرور"),
            'items' =>  [
                [
                    'title' =>  __("تغيير كلمه المرور"),
                    'url'   =>  '#!',
                ]
            ],
        ];

        return view('admin.pages.profile.change_password', compact('breadcrumb'));
    }

    public function update_password(UpdatePasswordRequest $request)
    {
        if ( !Hash::check($request->current_password, Auth::user()->password) ) {
            return Redirect::route('admin.change_password.index')->withErrors([
                'current_password' => __('كلمة المرور الحالية غير صحيحه')
            ]);
        }
        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);
        Auth::logout();
        return Redirect::route('admin.change_password.index')->with('success', __("تم تغير كلمة المرور",['item' => __('Password')]) );

    }

    public function change_store_information() {
        if(!in_array(User::TYPE_STORE,\Auth::user()->roles()->pluck("name")->toArray())) {
            abort(404);
        }
        $breadcrumb = [
            'title' =>  __("بيانات المتجر"),
            'items' =>  [
                [
                    'title' =>  __("بيانات المتجر"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $storeRequest     = \Auth::user()->storeRequest;
        $storeSettings    = \Auth::user()->storeSettings;
        $storeCategories  = \Auth::user()->storeCategories;
        return view('admin.pages.profile.store_information',get_defined_vars());
    }

    public function update_store_information(UpdateStoreDataRequest $request) {
        if(!in_array(User::TYPE_STORE,\Auth::user()->roles()->pluck("name")->toArray())) {
            abort(404);
        }
        $data           = $request->all();
        $storeRequest   = [
            'username'      => $data["username"],
            'store_name'    => $data["store_name"],
            'email'         => $data["email"],
            'phone'         => $data["phone"],
        ];
        $storeSettings  = [
            // 'vat'                   => $data["vat"],
            'short_description'     => $data["short_description"],
            'terms_information'     => $data["terms_information"],
            'return_information'    => $data["return_information"],
        ];
        if($request->hasFile('photo')){
            $storeSettings['photo'] = (new \App\Support\Image)->FileUpload($request->photo, 'storeRequest');
        }
        if($request->hasFile('cover')){
            $storeSettings['cover'] = (new \App\Support\Image)->FileUpload($request->cover, 'storeRequest');
        }
        if(is_null(\Auth::user()->storeRequest)) {
            $storeRequest["plan_id"]    = 1;
            \Auth::user()->storeRequest()->create($storeRequest);
        } else {
            \Auth::user()->storeRequest()->update($storeRequest);
        }
        if(is_null(\Auth::user()->storeSettings)) {
            \Auth::user()->storeSettings()->create($storeSettings);
        } else {
            \Auth::user()->storeSettings()->update($storeSettings);
        }
        if(request()->has("categories")) {
            \Auth::user()->storeCategories()->sync(request("categories",[]));
        }
        return Redirect::route('admin.change_store_information.index')->with('success', __("تم تحديث البيانات بنجاح") );
    }

}
