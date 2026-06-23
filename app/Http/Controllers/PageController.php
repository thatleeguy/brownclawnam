<?php

namespace App\Http\Controllers;

use App\Models\Capability;
use App\Models\CaseStudy;
use App\Models\FirmContent;
use App\Models\HomeContent;
use App\Models\Insight;
use App\Models\TeamMember;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'home'          => HomeContent::current(),
            'team'          => TeamMember::visible()->ordered()->get(),
            'capabilities'  => Capability::published()->ordered()->limit(3)->get(),
            'featuredCase'  => CaseStudy::published()->featured()->orderByDesc('published_at')->first()
                                ?? CaseStudy::published()->orderByDesc('published_at')->first(),
            'relatedCases'  => CaseStudy::published()->ordered()->limit(4)->get(),
            'insights'      => Insight::published()->ordered()->limit(3)->get(),
        ]);
    }

    public function firm()
    {
        return view('pages.firm', [
            'firm' => FirmContent::current(),
            'team' => TeamMember::visible()->ordered()->get(),
        ]);
    }
}
