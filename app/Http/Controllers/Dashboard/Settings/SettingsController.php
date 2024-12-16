<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
   
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Settings List"),
            'items' =>  [
                [
                    'title' =>  __("Settings List"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Setting::FORM_INPUTS;
        return view('admin.pages.settings.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'=>$lists,
        ]);
    }

    public function edit($group_by = null)
    {
        $lists = Setting::FORM_INPUTS;
        if(is_null($group_by) || !key_exists($group_by,$lists)) {
            abort(404);
        }
        $breadcrumb = [
            'title' =>  __("Edit Settings"),
            'items' =>  [
                [
                    'title' =>  __("Settings List"),
                    'url'   =>  route('admin.settings.index'),
                ],
                [
                    'title' =>  __("Edit Settings"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $form = $lists[$group_by]['form'];
        return view('admin.pages.settings.edit',[
            'breadcrumb'=>$breadcrumb,
            'group_by'=>$group_by,
            'form'=>$form,
        ]);
    }
    public function update(Request $request, $group_by = null)
    {
        $lists = Setting::FORM_INPUTS;
        if(is_null($group_by) || !key_exists($group_by,$lists)) {
            abort(404);
        }
        $request = request()->all();
        unset($request['_token']);
        unset($request['_method']);
        $data = [];
        foreach($request as $key=>$value) {
            $check = Setting::where(['key' => $key,'group_by'=> $group_by])->first();
            if(!is_null($check)) {
                $check->update([
                    "value" => $this->filterValue($value)
                    ]);
            } else {
                $data['key']       = $key;
                $data['group_by']  = $group_by;
                $data['value']     = $this->filterValue($value);
                Setting::create($data);
            }
        }
        return Redirect::route('admin.settings.index', ['group_by' => $group_by])->with('success', __("تم تحديث البيانات"));
    }

    public function filterValue($value)
    {
        if ($value instanceof UploadedFile) {
            $value = (new \App\Support\Image)->FileUpload($value, 'stander');
        }
        if (is_array($value) ) {
            foreach($value as $k => $v) {
                $value = $v;
            }
        }
        return $value;
    }
}
