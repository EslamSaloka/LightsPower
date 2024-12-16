<?php

namespace App\Http\Controllers\API\Contacts;

// Controllers
use App\Http\Controllers\Controller;
// Http
use Illuminate\Http\Request;
use App\Http\Requests\API\Contacts\ContactsRequests;
// Models
use App\Models\Contact;
// Support
use App\Support\API;

class ContactsController extends Controller
{
    public function store(ContactsRequests $request) {
        $request = $request->all();
        $request["user_id"] = \Auth::user()->id;
        Contact::create($request);
        return (new API)->isOk(__("تم إرسال رسالتك بنجاح"))->build();
    }
}
