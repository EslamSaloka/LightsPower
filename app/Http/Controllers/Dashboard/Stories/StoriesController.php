<?php

namespace App\Http\Controllers\Dashboard\Stories;

use App\Http\Controllers\Controller;
// Request
use Illuminate\Http\Request;
use App\Http\Requests\Dashboard\Stories\CreateRequest;
use App\Http\Requests\Dashboard\Stories\UpdateRequest;
// Models
use App\Models\Story;

class StoriesController extends Controller
{
    protected $fileName = "stories";
    protected $controllerName = "القصص";
    protected $routeName = "stories";

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
        $lists = new Story;
        if(request()->has("user_id") && request("user_id") != "-1") {
            $lists = $lists->where("user_id",request("user_id"));
        }
        $lists = $lists->latest()->paginate();
        return view("admin.pages.$this->fileName.index",get_defined_vars());
    }

    public function show(Request $request,Story $story) {
        $breadcrumb = [
            'title' =>  __("قائمة $this->controllerName"),
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
        return view("admin.pages.$this->fileName.show",get_defined_vars());
    }

    public function create() {
        $breadcrumb = [
            'title' =>  __("إضافة قصة جديدة"),
            'items' =>  [
                [
                    'title' =>  __("قائمة القصص"),
                    'url'   => route("admin.$this->fileName.index"),
                ],
                [
                    'title' =>  __("إضافة قصة جديدة"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        return view("admin.pages.$this->fileName.edit",get_defined_vars());
    }

    public function store(CreateRequest $request) {
        $data = $request->all();
        $data['video'] = (new \App\Support\Image)->FileUpload(request('image'), 'stories');
        $data["user_id"] = 1;
        $data["specialty_id"] = 1;
        Story::create($data);
        return redirect()->route("admin.$this->fileName.index")->with('success', __("تم إضافه قصتك بنجاح", ['item' => __('User')]));
    }

    public function destroy(Story $story) {
        $story->delete();
        return redirect()->route("admin.$this->fileName.index")->with('success',__('تم حذف البيانات'));
    }
}
