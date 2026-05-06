@extends('layouts.site')
@section('title', 'Contact — Brownclaw Asset Management')
@section('description', 'Request an engagement with Brownclaw Asset Management. First conversations are free and structured.')

@push('head')
<style>
.cform{ display:flex; flex-direction:column; gap: 18px; max-width: 560px; }
.cform .field{ display:flex; flex-direction:column; gap: 6px; }
.cform label{
  font-family:var(--mono); font-size:10.5px; letter-spacing:.16em;
  text-transform:uppercase; color: var(--mute);
}
.cform input, .cform textarea{
  background: var(--steel-2);
  border: 1px solid var(--rule-2);
  color: var(--txt);
  padding: 12px 14px;
  font-family: var(--body); font-size: 15px;
  outline: none;
  transition: border-color .2s;
}
.cform input:focus, .cform textarea:focus{ border-color: var(--amber); }
.cform textarea{ resize: vertical; min-height: 140px; line-height: 1.5; }
.cform .err{ font-family: var(--mono); font-size: 11px; color: var(--hazard); margin-top: 4px; letter-spacing: 0.04em; }
.cform .submit{
  display:inline-flex; align-items:center; gap: 12px;
  padding: 14px 22px;
  background: var(--amber); color: var(--steel-0);
  font-family: var(--mono); font-size: 12px; font-weight: 700;
  letter-spacing: 0.16em; text-transform: uppercase;
  border: 1px solid var(--amber); cursor: pointer;
  transition: background .2s, transform .2s;
  align-self: flex-start;
}
.cform .submit:hover{ background: #FFB937; }
.cform .hp{ position: absolute; left: -9999px; }
.success-banner{
  background: rgba(242,168,42,0.10);
  border: 1px solid var(--amber);
  padding: 18px 20px;
  margin-bottom: 28px;
  font-family: var(--body); font-size: 15px;
  color: var(--txt);
}
.success-banner b{ color: var(--amber); font-weight: 600; }
</style>
@endpush

@section('content')
<section class="hero" style="padding-bottom: clamp(48px, 6vw, 80px);">
  <div class="wrap">
    <span class="eyebrow reveal">REQUEST · ENGAGEMENT INTAKE</span>
    <h1 class="reveal d1" style="margin-top:18px">Let's talk about <span class="am">your reliability program.</span></h1>
    <p class="hero-sub reveal d2">
      First conversations are free and structured. Thirty minutes is
      usually enough to know whether we're a fit.
    </p>
  </div>
</section>

<section style="padding: 0 0 clamp(80px, 9vw, 144px);">
  <div class="wrap" style="display:grid; grid-template-columns: 1.1fr 1fr; gap: clamp(40px, 6vw, 80px); align-items: start;">
    <div class="reveal">
      @if(session('success'))
        <div class="success-banner">
          <b>Received.</b> Connor will be in touch inside one business day.
        </div>
      @endif

      <form action="{{ route('contact.store') }}" method="POST" class="cform">
        @csrf

        <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" />

        <div class="field">
          <label for="name">Your name</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" required />
          @error('name')<div class="err">{{ $message }}</div>@enderror
        </div>

        <div class="field">
          <label for="company">Company / operation</label>
          <input type="text" id="company" name="company" value="{{ old('company') }}" />
          @error('company')<div class="err">{{ $message }}</div>@enderror
        </div>

        <div class="field">
          <label for="role">Your role</label>
          <input type="text" id="role" name="role" placeholder="e.g. Maintenance Superintendent" value="{{ old('role') }}" />
          @error('role')<div class="err">{{ $message }}</div>@enderror
        </div>

        <div class="field">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required />
          @error('email')<div class="err">{{ $message }}</div>@enderror
        </div>

        <div class="field">
          <label for="phone">Phone (optional)</label>
          <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" />
          @error('phone')<div class="err">{{ $message }}</div>@enderror
        </div>

        <div class="field">
          <label for="message">What's on your floor?</label>
          <textarea id="message" name="message" rows="6" required placeholder="Bring your worst bad-actor or the program problem you're trying to solve.">{{ old('message') }}</textarea>
          @error('message')<div class="err">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="submit">
          REQUEST ENGAGEMENT
          <svg class="arr" width="14" height="10" viewBox="0 0 14 10"><path d="M1 5h11M8 1l4 4-4 4" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </form>
    </div>

    <aside class="contact-card reveal d1">
      <div class="row">
        <div>
          <div class="l">DIRECT</div>
          <div class="v"><a href="mailto:info@brownclawam.ca">info@brownclawam.ca</a></div>
          <div class="small">Replies inside 24 hrs, Mon–Fri.</div>
        </div>
      </div>
      <div class="row">
        <div>
          <div class="l">TELEPHONE</div>
          <div class="v"><a href="tel:+18662586572">+1 (866) 258-6572</a></div>
          <div class="small">Pacific time. Voicemail forwards to email.</div>
        </div>
      </div>
      <div class="row">
        <div>
          <div class="l">LOCATED</div>
          <div class="v">Fernie, British Columbia</div>
          <div class="small">Working on-site across Western Canada and the Rocky Mountain corridor.</div>
        </div>
      </div>
    </aside>
  </div>
</section>
@endsection
