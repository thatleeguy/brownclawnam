<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactSubmissionReceived;
use App\Models\ContactSubmission;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contact');
    }

    public function store(StoreContactRequest $request)
    {
        $submission = ContactSubmission::create([
            ...$request->validated(),
            'source'     => 'contact-page',
            'ip_hash'    => hash('sha256', $request->ip() . config('app.key')),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        $this->notifyOfSubmission($submission);

        return redirect()->route('contact')->with('success', true);
    }

    /**
     * Email the firm about a new submission.
     *
     * The row is already saved by this point, so a mail failure must never
     * reach the visitor — it gets logged and swallowed instead.
     */
    private function notifyOfSubmission(ContactSubmission $submission): void
    {
        $recipient = config('mail.contact_notify_to') ?: SiteSetting::current()->contact_email;

        if (blank($recipient)) {
            Log::warning('No contact notification recipient configured; skipping email.', [
                'submission_id' => $submission->id,
            ]);

            return;
        }

        try {
            Mail::to($recipient)->send(new ContactSubmissionReceived($submission));
        } catch (\Throwable $e) {
            Log::error('Contact notification failed to send.', [
                'submission_id' => $submission->id,
                'recipient'     => $recipient,
                'exception'     => $e->getMessage(),
            ]);
        }
    }
}
