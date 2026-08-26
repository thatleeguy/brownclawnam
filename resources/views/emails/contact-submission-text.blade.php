NEW ENGAGEMENT REQUEST — Brownclaw Asset Management

Name: {{ $submission->name }}
Email: {{ $submission->email }}
@if (filled($submission->company))
Company: {{ $submission->company }}
@endif
@if (filled($submission->role))
Role: {{ $submission->role }}
@endif
@if (filled($submission->phone))
Phone: {{ $submission->phone }}
@endif

MESSAGE
{{ $submission->message }}

--
Submitted {{ $submission->created_at->format('D j M Y, g:ia') }} via {{ $submission->source }}
Open in admin: {{ url('/admin/contact-submissions/' . $submission->id . '/edit') }}
Replying to this email goes straight to {{ $submission->name }}.
