<?php

namespace App\Http\Controllers\Dashboard\Specialties;

use App\Http\Controllers\Controller;
// Request
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Specialties\CreateOrUpdateRequest;
// Models
use App\Models\Specialty;

class SpecialtiesController extends Controller
{
    protected $fileName = "specialties";
    protected $controllerName = "المدارات";
    protected $routeName = "specialties";

    public function index() {
        $breadcrumb = [
            'title' =>  __("قائمة $this->controllerName"),
            'items' =>  [
                [
                    'title' =>  __("قائمة $this->controllerName"),
                    'url'   =>  route("admin.$this->routeName.index"),
                ]
            ],
        ];
        $lists = Specialty::latest()->paginate();
        return view("admin.pages.$this->fileName.index",get_defined_vars());
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("قائمة $this->controllerName"),
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
        return view("admin.pages.$this->fileName.edit",get_defined_vars());
    }

    public function store(CreateOrUpdateRequest $request) {
        $data = $request->validated();
        if($request->hasFile('image')){
            $data['image'] = (new \App\Support\Image)->FileUpload($request->image, 'specialty');
        } else {
            $data['image'] = null;
        }
        Specialty::create($data);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('تم حفظ البيانات بنجاح'));
    }

    public function edit(Request $request,Specialty $specialty) {
        // if($specialty->id == 1) {
        //     return redirect()->route("admin.$this->fileName.index")->with('success',__('لا يمكنك تعديل هذا المدار'));
        // }
        $breadcrumb = [
            'title' =>  __("قائمة $this->controllerName"),
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
        return view("admin.pages.$this->fileName.edit",get_defined_vars());
    }

    public function update(CreateOrUpdateRequest $request,Specialty $specialty) {
        // if($specialty->id == 1) {
        //     return redirect()->route("admin.$this->fileName.index")->with('success',__('لا يمكنك تعديل هذا المدار'));
        // }
        $data = $request->validated();
        if($request->hasFile('image')){
            $data['image'] = (new \App\Support\Image)->FileUpload($request->image, 'specialty');
        }
        $specialty->update($data);
        return redirect()->route("admin.$this->fileName.index")->with('success',__('تم تحديث البيانات بنجاح'));
    }

    public function destroy(Specialty $specialty) {
        if($specialty->id == 1) {
            return redirect()->route("admin.$this->fileName.index")->with('success',__('لا يمكنك حذف هذا المدار'));
        }
        $specialty->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('تم حذف البيانات'));
    }
}
