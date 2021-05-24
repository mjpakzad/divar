<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\ContactRequest;
use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $contact = Contact::create($request->only(['name', 'email', 'mobile', 'content']));
        $this->doneMessage('پیام شما با موفقیت برای مدیریت سایت ارسال گردید.');
        return redirect()->route('frontend.pages.show', 'call');
    }
}
