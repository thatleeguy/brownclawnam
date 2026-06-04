<?php

use App\Models\HomeContent;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Update the seeded HomeContent singleton (id=1) to reflect the 2026-06
     * client branding edits: drop "Principal" / P.Eng / CMRP from the homepage
     * position signature and hero spec row.
     */
    public function up(): void
    {
        $hc = HomeContent::find(1);

        if (! $hc) {
            return;
        }

        $hc->position_signature_name = 'Connor Schriver · Founder';

        $hc->spec_row = collect($hc->spec_row ?? [])
            ->reject(fn ($r) => ($r['label'] ?? '') === 'Credentials')
            ->map(fn ($r) => ($r['label'] ?? '') === 'Practice yrs'
                ? array_merge($r, ['value' => '9'])
                : $r)
            ->values()
            ->all();

        $hc->save();
    }

    public function down(): void
    {
        $hc = HomeContent::find(1);

        if (! $hc) {
            return;
        }

        $hc->position_signature_name = 'Connor Schriver, P.Eng, CMRP · Principal';

        $spec = collect($hc->spec_row ?? [])
            ->map(fn ($r) => ($r['label'] ?? '') === 'Practice yrs'
                ? array_merge($r, ['value' => '8'])
                : $r)
            ->values()
            ->all();

        // Restore the Credentials cell if it was removed.
        if (! collect($spec)->contains(fn ($r) => ($r['label'] ?? '') === 'Credentials')) {
            $spec[] = ['label' => 'Credentials', 'value' => 'P.Eng', 'unit' => '·CMRP'];
        }

        $hc->spec_row = $spec;
        $hc->save();
    }
};
