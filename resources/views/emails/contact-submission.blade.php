@php($adminUrl = url('/admin/contact-submissions/' . $submission->id . '/edit'))
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>New engagement request</title>
</head>
<body style="margin:0; padding:24px 0; background:#f4f4f2; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif; color:#1c1c1c;">

  <div style="max-width:560px; margin:0 auto; background:#ffffff; border:1px solid #e3e3df;">

    <div style="background:#14171a; padding:20px 28px; border-bottom:3px solid #F2A82A;">
      <div style="font-size:11px; letter-spacing:0.16em; text-transform:uppercase; color:#F2A82A; font-weight:700;">
        Brownclaw Asset Management
      </div>
      <div style="font-size:17px; color:#ffffff; margin-top:6px;">
        New engagement request
      </div>
    </div>

    <div style="padding:28px;">

      <table cellpadding="0" cellspacing="0" border="0" style="width:100%; font-size:15px; line-height:1.5;">
        @foreach ([
            'Name'    => $submission->name,
            'Email'   => $submission->email,
            'Company' => $submission->company,
            'Role'    => $submission->role,
            'Phone'   => $submission->phone,
        ] as $label => $value)
          @if (filled($value))
            <tr>
              <td style="padding:0 12px 10px 0; color:#6b6b66; font-size:12px; letter-spacing:0.08em; text-transform:uppercase; white-space:nowrap; vertical-align:top;">
                {{ $label }}
              </td>
              <td style="padding:0 0 10px 0; vertical-align:top;">
                @if ($label === 'Email')
                  <a href="mailto:{{ $submission->email }}" style="color:#1c1c1c;">{{ $value }}</a>
                @else
                  {{ $value }}
                @endif
              </td>
            </tr>
          @endif
        @endforeach
      </table>

      <div style="margin-top:22px; padding-top:20px; border-top:1px solid #e3e3df;">
        <div style="color:#6b6b66; font-size:12px; letter-spacing:0.08em; text-transform:uppercase; margin-bottom:8px;">
          Message
        </div>
        <div style="font-size:15px; line-height:1.6; white-space:pre-wrap;">{{ $submission->message }}</div>
      </div>

      <div style="margin-top:28px;">
        <a href="{{ $adminUrl }}" style="display:inline-block; background:#F2A82A; color:#14171a; padding:12px 20px; font-size:12px; font-weight:700; letter-spacing:0.14em; text-transform:uppercase; text-decoration:none;">
          Open in admin
        </a>
      </div>

      <div style="margin-top:24px; color:#8a8a84; font-size:12px;">
        Submitted {{ $submission->created_at->format('D j M Y, g:ia') }} &middot; via {{ $submission->source }}<br />
        Replying to this email goes straight to {{ $submission->name }}.
      </div>

    </div>
  </div>

</body>
</html>
