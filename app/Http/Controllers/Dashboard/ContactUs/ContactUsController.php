<?php

namespace App\Http\Controllers\Dashboard\ContactUs;

use App\Http\Controllers\Controller;
// Request
use Illuminate\Http\Request;
// Models
use App\Models\Contact;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = [
            'title' =>  __("قائمة رسائل التواصل"),
            'items' =>  [
                [
                    'title' =>  __("قائمة رسائل التواصل"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = new Contact;
        if(request()->has("name")) {
            // if(is_numeric(request("name"))) {
            //     $lists = $lists->where("phone","like","%".request("name")."%");
            // } else if(filter_var(request("name"), FILTER_VALIDATE_EMAIL)) {
            //     $lists = $lists->where("email","like","%".request("name")."%");
            // } else {
            //     $lists = $lists->where("name","like","%".request("name")."%");
            // }
            $lists = $lists->whereHas("user",function($q){
                if(is_numeric(request("name"))) {
                    return $q->where("phone","like","%".request("name")."%");
                } else if(filter_var(request("name"), FILTER_VALIDATE_EMAIL)) {
                    return $q->where("email","like","%".request("name")."%");
                } else {
                    return $q->where("username","like","%".request("name")."%");
                }
            });
        }
        if(request()->has("seen") && request("seen") != -1) {
            $lists = $lists->where("seen",request("seen"));
        }
        $lists = $lists->latest()->paginate();
        return view('admin.pages.contact-us.index',[
            'breadcrumb' => $breadcrumb,
            'lists'      => $lists,
        ]);
    }

    public function show(Contact $contact_u)
    {
        if($contact_u->seen == 0) {
            $contact_u->update([
                'seen'    => 1
            ]);
        }
        $breadcrumb = [
            'title' =>  __("Show message"),
            'items' =>  [
                [
                    'title' =>  __("قائمة رسائل التواصل"),
                    'url'   =>  route('admin.contact-us.index'),
                ],
                [
                    'title' =>  __("Show message"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        return view('admin.pages.contact-us.show',[
            'breadcrumb'=>$breadcrumb,
            'contact_u'=>$contact_u,
        ]);
    }

    public function destroy(Request $request,Contact $contact_u)
    {
        $contact_u->delete();
        return redirect()->route('admin.contact-us.index')->with('success', __("تم حذف الرسالة بنجاح",['item' => __('Message')]) );
    }
}
