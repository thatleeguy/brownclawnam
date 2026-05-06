<?php

namespace App\Http\Controllers;

use App\Models\Capability;

class CapabilityController extends Controller
{
    public function index()
    {
        return view('pages.capabilities.index', [
            'capabilities' => Capability::published()->ordered()->get(),
        ]);
    }

    public function show(Capability $capability)
    {
        abort_unless($capability->published_at && $capability->published_at->isPast(), 404);

        return view('pages.capabilities.show', [
            'capability' => $capability,
            'others'     => Capability::published()->where('id', '!=', $capability->id)->ordered()->get(),
        ]);
    }
}
