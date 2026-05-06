<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contact');
    }

    public function store(StoreContactRequest $request)
    {
        ContactSubmission::create([
            ...$request->validated(),
            'source'     => 'contact-page',
            'ip_hash'    => hash('sha256', $request->ip() . config('app.key')),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        return redirect()->route('contact')->with('success', true);
    }
}
