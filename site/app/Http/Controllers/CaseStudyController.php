<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;

class CaseStudyController extends Controller
{
    public function index()
    {
        return view('pages.work.index', [
            'cases' => CaseStudy::published()->ordered()->paginate(12),
        ]);
    }

    public function show(CaseStudy $work)
    {
        abort_unless($work->published_at && $work->published_at->isPast(), 404);

        return view('pages.work.show', [
            'case'    => $work,
            'related' => CaseStudy::published()->where('id', '!=', $work->id)->ordered()->limit(3)->get(),
        ]);
    }
}
