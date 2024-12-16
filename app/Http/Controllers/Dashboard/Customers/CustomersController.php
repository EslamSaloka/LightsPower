<?php

namespace App\Http\Controllers\Dashboard\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Customers\CreateRequest;
use App\Http\Requests\Dashboard\Customers\UpdateRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

class CustomersController extends Controller
{

    protected $fileName         = "customers";
    protected $controllerName   = "المستخدمين";
    protected $routeName        = "customers";
    protected $userRole         = User::TYPE_CUSTOMER;

    public function index(Request $request)
    {
        $breadcrumb = [
            'title' =>  __("قائمة $this->controllerName"),
            'items' =>  [
                [
                    'title' =>  __("قائمة $this->controllerName"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ]
            ],
        ];
        $lists = User::whereHas('roles', function($q) {
                return $q->where('name', '=', $this->userRole);
            });
        if(request()->has("name")) {
            if(is_numeric(request("name"))) {
                $lists = $lists->where("phone","like","%".request("name")."%");
            } else if(filter_var(request("name"), FILTER_VALIDATE_EMAIL)) {
                $lists = $lists->where("email","like","%".request("name")."%");
            } else {
                $lists = $lists->where("username","like","%".request("name")."%");
            }
        }
        if(request()->has("suspend") && request("suspend") != "-1") {
            $lists = $lists->where("suspend",request("suspend"));
        }
        $lists = $lists->whereNotNull("completed_at")->latest()->paginate();
        $roles = Role::where('name', '=', $this->userRole)->get();
        return view("admin.pages.$this->fileName.index",compact('breadcrumb', 'lists', 'roles'));
    }

    public function create()
    {
        $breadcrumb = [
            'title' =>  __("إضافه $this->controllerName"),
            'items' =>  [
                [
                    'title' =>  __("قائمة $this->controllerName"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("إضافه $this->controllerName"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view("admin.pages.$this->fileName.edit", compact('breadcrumb'));
    }

    public function store(CreateRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);
        $data['email_verified_at'] = Carbon::now();
        if($request->hasFile('avatar')) {
            $data['avatar'] = (new \App\Support\Image)->FileUpload($request->avatar, 'users');
        }
        $data['suspend'] = 0;
        $customer = User::create($data);
        $customer->assignRole($this->userRole);
        return Redirect::route("admin.$this->fileName.index")->with('success', __("تم إضافه البيانات بنجاح", ['item' => __('User')]));
    }

    public function show(User $customer)
    {
        if(!in_array($this->userRole,$customer->roles()->pluck("name")->toArray())) {
            return Redirect::route("admin.$this->fileName.index")->with('danger', __("هذا الحساب غير صالح الإستخدام هنا") );
        }
        $breadcrumb = [
            'title' =>  __("عرض $this->controllerName"),
            'items' =>  [
                [
                    'title' =>  __("قائمة $this->controllerName"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("عرض $this->controllerName"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view("admin.pages.$this->fileName.show", compact('breadcrumb', 'customer'));
    }

    public function edit(User $customer)
    {
        if(!in_array($this->userRole,$customer->roles()->pluck("name")->toArray())) {
            return Redirect::route("admin.$this->fileName.index")->with('danger', __("هذا الحساب غير صالح الإستخدام هنا") );
        }
        $breadcrumb = [
            'title' =>  __("تعديل $this->controllerName"),
            'items' =>  [
                [
                    'title' =>  __("قائمة $this->controllerName"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ],
                [
                    'title' =>  __("تعديل $this->controllerName"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $user = $customer;
        $roles = Role::whereNotIn('name', [User::TYPE_CUSTOMER])->get();

        return view("admin.pages.$this->fileName.edit", compact('breadcrumb', 'user', 'roles'));
    }

    public function update(UpdateRequest $request, User $customer)
    {
        if(!in_array($this->userRole,$customer->roles()->pluck("name")->toArray())) {
            return Redirect::route("admin.$this->fileName.index")->with('danger', __("هذا الحساب غير صالح الإستخدام هنا") );
        }
        $data = $request->all();
        if(request()->has('password') && !is_null(request('password'))) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }
        if( $request->hasFile('avatar') ) {
            $data['avatar'] = (new \App\Support\Image)->FileUpload($request->avatar, 'users');
        }
        if(is_null($data["email"])) {
            unset($data["email"]);
        }
        $customer->update($data);
        if($customer->suspend == 1) {
            $customer->deleteTokens();
            (new \App\Support\FireBase)->setTitle(env("APP_NAME"))
            ->setBody("تم حظر عضويتك من قبل الإدارة برجاء التواصل مع الدعم الفني")
            ->setToken($customer->tokens()->pluck("token")->toArray())
            ->build();
            \DB::table("user_tokens")->where("user_id",$customer->id)->delete();
        }
        return Redirect::route("admin.$this->fileName.index", ['page' => $request->page ?? 1])->with('success', __("تم تحديث البيانات", ['item' => __('User')]));
    }


    public function destroy(User $customer) {
        if(!in_array($this->userRole,$customer->roles()->pluck("name")->toArray())) {
            return Redirect::route("admin.$this->fileName.index")->with('danger', __("هذا الحساب غير صالح الإستخدام هنا") );
        }
        $customer->delete();
        return Redirect::route("admin.$this->fileName.index")->with('success', __("تم حذف البيانات.",['item' => __('User')]) );
    }
}
