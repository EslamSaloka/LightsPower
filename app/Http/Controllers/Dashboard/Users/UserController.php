<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\User\CreateUserRequest;
use App\Http\Requests\Dashboard\User\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $breadcrumb = [
            'title' =>  __("قائمة إداره الموظفين"),
            'items' =>  [
                [
                    'title' =>  __("قائمة إداره الموظفين"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = new User;
        if(request()->has("suspend") && request("suspend") != "-1") {
            $lists = $lists->where("suspend",request("suspend"));
        }
        if(request()->has("role_id") && request("role_id") != "-1") {
            $lists = $lists->whereHas('roles', function($q) {
                return $q->where('id', request("role_id"));
            });
        } else {
            $lists = $lists->whereHas('roles', function($q) {
                return $q->where('name', '!=', User::TYPE_CUSTOMER);
            });
        }

        if(request()->has("name") && request("name") != "") {
            if(is_numeric(request("name"))) {
                $lists = $lists->where("phone","like","%".request("name")."%");
            } else if(filter_var(request("name"), FILTER_VALIDATE_EMAIL)) {
                $lists = $lists->where("email","like","%".request("name")."%");
            } else {
                $lists = $lists->where("username","like","%".request("name")."%");
            }
        }

        $lists = $lists->where("id","!=",1)->latest()->paginate();
        $roles = Role::where('name', '!=', User::TYPE_CUSTOMER)->get();
        return view('admin.pages.users.index',compact('breadcrumb', 'lists', 'roles'));
    }

    public function create()
    {
        $breadcrumb = [
            'title' =>  __("إضافة موظف جديد"),
            'items' =>  [
                [
                    'title' =>  __("قائمة إداره الموظفين"),
                    'url'   => route('admin.users.index'),
                ],
                [
                    'title' =>  __("إضافة موظف جديد"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        $roles = Role::whereNotIn('name', [User::TYPE_CUSTOMER])->get();

        return view('admin.pages.users.edit', compact('breadcrumb', 'roles'));
    }

    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);
        $data['email_verified_at'] = Carbon::now();
        if($request->hasFile('avatar')) {
            $data['avatar'] = (new \App\Support\Image)->FileUpload($request->avatar, 'users');
        }
        if($request->hasFile('cover')) {
            $data['cover'] = (new \App\Support\Image)->FileUpload($request->cover, 'users');
        }
        $data['suspend'] = 0;
        $user = User::create($data);
        $user->assignRole($request->role);
        return Redirect::route('admin.users.index')->with('success', __(":item has been created.", ['item' => __('User')]));
    }

    public function edit(User $user)
    {
        if($user->id == \Auth::user()->id) {
            return redirect()->route('admin.profile.index');
        }
        $breadcrumb = [
            'title' =>  __("تعديل بيانات موظف الإداره"),
            'items' =>  [
                [
                    'title' =>  __("قائمة إداره الموظفين"),
                    'url'   => route('admin.users.index'),
                ],
                [
                    'title' =>  __("تعديل بيانات موظف الإداره"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $roles = Role::whereNotIn('name', [User::TYPE_CUSTOMER])->get();
        return view('admin.pages.users.edit', compact('breadcrumb', 'user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if(request()->has('password') && !is_null(request('password'))) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }
        if( $request->hasFile('avatar') ) {
            $data['avatar'] = (new \App\Support\Image)->FileUpload($request->avatar, 'users', $user->avatar);
        }
        if( $request->hasFile('cover') ) {
            $data['cover'] = (new \App\Support\Image)->FileUpload($request->cover, 'users', $user->cover);
        }
        $user->update($data);
        $user->syncRoles($request->role);
        return Redirect::route('admin.users.index', ['page' => $request->page ?? 1])->with('success', __(":item has been updated.", ['item' => __('User')]));
    }

    public function changeSuspended(User $user)
    {
        $user->update([
            'suspend' => ($user->suspend == 1) ? 0 : 1
        ]);
        $role = $user->roles->first() ? __($user->roles->first()->name) : "";
        $message = $user->suspend == 1
                        ? __('Deactivate the :type account successfully.', [
                            'type' => $role
                        ])
                        : __('Reactivate the :type account successfully.', [
                            'type' => $role
                        ]);
        return Redirect::route('admin.users.index')->with('success', $message);
    }

    public function show(User $user)
    {
        $breadcrumb = [
            'title' =>  __("Show user"),
            'items' =>  [
                [
                    'title' =>  __("قائمة إداره الموظفين"),
                    'url'   => route('admin.users.index'),
                ],
                [
                    'title' =>  __("Show user"),
                    'url'   =>  '#!',
                ],
            ],
        ];

        return view('admin.pages.users.show',[
            'breadcrumb'=>$breadcrumb,
            'user'=>$user,
        ]);
    }

    public function destroy(Request $request,User $user)
    {
        if($user->id != 1) {
            $user->delete();
        }
        return Redirect::route('admin.users.index')->with('success', __(":item has been deleted.",['item' => __('User')]) );
    }
}
