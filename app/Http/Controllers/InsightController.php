<?php

namespace App\Http\Controllers;

use App\Models\Insight;

class InsightController extends Controller
{
    public function index()
    {
        return view('pages.briefings.index', [
            'insights' => Insight::published()->ordered()->paginate(12),
        ]);
    }

    public function show(Insight $insight)
    {
        abort_unless($insight->published_at && $insight->published_at->isPast(), 404);

        return view('pages.briefings.show', [
            'insight' => $insight,
            'more'    => Insight::published()->where('id', '!=', $insight->id)->ordered()->limit(3)->get(),
        ]);
    }
}
