<?php

namespace App\Http\Controllers\Dashboard\Roles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Dashboard\Roles\UpdateRequest;
use App\Http\Requests\Dashboard\Roles\CreateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = [
            'title' =>  __("قائمة الصلاحيات"),
            'items' =>  [
                [
                    'title' =>  __("قائمة الصلاحيات"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Role::whereNotIn("id",[1,2,3])->get();
        
        return view('admin.pages.roles.index',compact('breadcrumb', 'lists'));
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("قائمة الصلاحيات"),
            'items' =>  [
                [
                    'title' =>  __("قائمة الصلاحيات"),
                    'url'   =>  route("admin.roles.index"),
                ],
                [
                    'title' =>  __("إضافه الصلاحيات"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view("admin.pages.roles.edit",get_defined_vars());
    }

    public function store(CreateRequest $request) {
        $data = $request->validated();
        $role = Role::create($data);
        $permissions = [];
        foreach($request->permissions ?? [] as $permission) {
            $permissions[] = Permission::firstOrCreate(['name' => $permission]);
        }
        $role->syncPermissions($permissions);
        return redirect()->route("admin.roles.index")->with('success',__('تم حفظ البيانات بنجاح'));
    }

    public function edit(Role $role)
    {
        if(in_array($role->id,[1,2,3])) {
            abort(404);
        }
        $breadcrumb = [
            'title' =>  __("تعديل الصلاحية"),
            'items' =>  [
                [
                    'title' =>  __("قائمة الصلاحيات"),
                    'url'   => route('admin.roles.index'),
                ],
                [
                    'title' =>  __("تعديل الصلاحية"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $permissions = $role->permissions->pluck('name')->toArray();
        
        return view('admin.pages.roles.edit',compact('breadcrumb', 'role', 'permissions'));
    }

    public function update(UpdateRequest $request, Role $role)
    {
        $data = $request->validated();
        if(!in_array($role->id,[1,2,3])) {
            $role->update($data);
        }
        $permissions = [];
        foreach($data['permissions'] ?? [] as $permission) {
            $permissions[] = Permission::firstOrCreate(['name' => $permission]);
        }
        $role->syncPermissions($permissions);
        return Redirect::route('admin.roles.index')->with('success',  __("تم تحديث البيانات",['item' => __('Role')]) );
    }

    public function destroy(Role $role)
    {
        if(in_array($role->id,[1,2,3])) {
            return Redirect::route('admin.rol]es.index')->with('success',  __("لا يمكنك حذف هذه الصلاحية",['item' => __('Role')]) );
        }
        $role->delete();
        return Redirect::route('admin.roles.index')->with('success',  __("اتم الحذف.",['item' => __('Role')]) );
    }
}
